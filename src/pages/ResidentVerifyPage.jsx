import React, { useEffect, useState, useRef } from 'react';
import { useParams } from 'react-router-dom';
import { apiService } from '../services/apiService';
import { ShieldCheck, User, Phone, Home, Briefcase, Clock, Camera, CameraOff, CheckCircle2, XCircle, Loader2, AlertTriangle } from 'lucide-react';
import { io } from 'socket.io-client';
import '../styles/resident-verify.css';

export default function ResidentVerifyPage() {
    const { id } = useParams();

    const [visitor, setVisitor] = useState(null);
    const [loadError, setLoadError] = useState(null);
    const [cameraError, setCameraError] = useState(false);
    const [decision, setDecision] = useState(null);
    const [processing, setProcessing] = useState(false);
    const [isRejecting, setIsRejecting] = useState(false);
    const [rejectReason, setRejectReason] = useState('Not available at home');

    const videoRef = useRef(null);
    const socketRef = useRef(null);
    const peerRef = useRef(null);

    useEffect(() => {
        (async () => {
            try {
                const res = await apiService.getRequestDetails(id);
                setVisitor(res.data);
                if (res.data.status === 'approved') setDecision('approved');
                if (res.data.status === 'denied') setDecision('denied');
            } catch (err) {
                setLoadError(err.message);
            }
        })();
    }, [id]);

    useEffect(() => {
        if (!visitor || decision) return;

        const socket = io('/');
        socketRef.current = socket;

        const peer = new RTCPeerConnection({ iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] });
        peerRef.current = peer;

        socket.emit('join-room', id);

        peer.ontrack = (event) => {
            if (videoRef.current) {
                videoRef.current.srcObject = event.streams[0];
            }
        };

        peer.onicecandidate = (event) => {
            if (event.candidate) {
                socket.emit('ice-candidate', { roomId: id, candidate: event.candidate });
            }
        };

        socket.on('offer', async (offer) => {
            try {
                await peer.setRemoteDescription(new RTCSessionDescription(offer));
                const answer = await peer.createAnswer();
                await peer.setLocalDescription(answer);
                socket.emit('answer', { roomId: id, answer });
            } catch (e) {
                console.error("WebRTC Offer error:", e);
                setCameraError(true);
            }
        });

        socket.on('ice-candidate', async (candidate) => {
            try {
                await peer.addIceCandidate(new RTCIceCandidate(candidate));
            } catch (e) {
                console.error('Error adding ICE candidate', e);
            }
        });

        // If the tablet camera is just ready now, we can send our presence again
        socket.on('visitor-ready', () => {
            socket.emit('resident-joined', id);
        });

        // Trigger the gate tablet to send an offer
        socket.emit('resident-joined', id);

        socket.on('status-update', (data) => {
            if (data.status === 'approved' || data.status === 'denied') {
                setDecision(data.status);
            }
        });

        return () => {
            socket.disconnect();
            peer.close();
        };
    }, [visitor, decision, id]);

    const handleApprove = async () => {
        setProcessing(true);
        try {
            await apiService.approveVisitor(id);
            // setDecision is handled automatically via socket 'status-update'
        } catch (err) {
            alert('Error: ' + err.message);
            setProcessing(false);
        }
    };

    const handleRejectClick = () => setIsRejecting(true);
    const handleCancelReject = () => { setIsRejecting(false); setRejectReason('Not available at home'); };

    const handleConfirmReject = async () => {
        setProcessing(true);
        try {
            await apiService.rejectVisitor(id, rejectReason);
            // setDecision is handled automatically via socket 'status-update'
        } catch (err) {
            alert('Error: ' + err.message);
            setProcessing(false);
        }
    };

    if (loadError) {
        return (
            <div className="rv-page">
                <div className="rv-card rv-card--error">
                    <AlertTriangle size={48} color="#f87171" />
                    <h2>Request Not Found</h2>
                    <p>{loadError}</p>
                    <p className="rv-hint">The link may have expired or is invalid.</p>
                </div>
            </div>
        );
    }

    if (!visitor) {
        return (
            <div className="rv-page">
                <div className="rv-card rv-card--loading">
                    <Loader2 size={40} className="rv-spin" color="#2563eb" />
                    <p>Loading visitor details…</p>
                </div>
            </div>
        );
    }

    if (decision === 'approved') {
        return (
            <div className="rv-page">
                <div className="rv-card rv-card--approved">
                    <div className="rv-outcome-icon rv-outcome-icon--green">
                        <CheckCircle2 size={52} color="#10b981" />
                    </div>
                    <h2 className="rv-outcome-title rv-green">Entry Approved</h2>
                    <p className="rv-outcome-desc">You have approved <strong>{visitor.name}</strong>.<br />The gate is opening.</p>
                    <div className="rv-outcome-badge rv-badge--green">
                        <ShieldCheck size={15} /> Visitor granted access
                    </div>
                </div>
            </div>
        );
    }

    if (decision === 'denied') {
        return (
            <div className="rv-page">
                <div className="rv-card rv-card--denied">
                    <div className="rv-outcome-icon rv-outcome-icon--red">
                        <XCircle size={52} color="#ef4444" />
                    </div>
                    <h2 className="rv-outcome-title rv-red">Entry Denied</h2>
                    <p className="rv-outcome-desc">You have rejected the entry request from <strong>{visitor.name}</strong>.</p>
                    <div className="rv-outcome-badge rv-badge--red">Visitor has been notified</div>
                </div>
            </div>
        );
    }

    return (
        <div className="rv-page">
            <div className="rv-card">
                <div className="rv-header">
                    <ShieldCheck size={22} className="rv-logo-icon" />
                    <div>
                        <div className="rv-header-title">SecureGate</div>
                        <div className="rv-header-sub">Visitor Approval Request</div>
                    </div>
                </div>

                <div className="rv-section">
                    <h3 className="rv-section-title">Visitor Information</h3>
                    <div className="rv-info-grid">
                        <InfoRow icon={<User size={15} />} label="Name" value={visitor.name} />
                        <InfoRow icon={<Phone size={15} />} label="Phone" value={visitor.phone} />
                        <InfoRow icon={<Home size={15} />} label="Your Flat" value={visitor.flat} />
                        <InfoRow icon={<Briefcase size={15} />} label="Purpose" value={visitor.purpose} />
                        <InfoRow icon={<Clock size={15} />} label="Time" value={visitor.timestamp} />
                    </div>
                </div>

                <div className="rv-section">
                    <h3 className="rv-section-title">Live Camera at Gate</h3>
                    <div className="rv-camera-frame">
                        {cameraError ? (
                            <div className="rv-camera-error">
                                <CameraOff size={28} />
                                <span>Gate Camera connecting... or unavailable</span>
                            </div>
                        ) : (
                            <video ref={videoRef} autoPlay playsInline muted className="rv-video" />
                        )}
                        {!cameraError && (
                            <div className="rv-live-badge">
                                <span className="rv-live-dot" />LIVE
                            </div>
                        )}
                        <div className="rv-camera-hint">
                            <Camera size={13} />
                            <span>Live video from gate tablet</span>
                        </div>
                    </div>
                </div>

                {isRejecting ? (
                    <div className="rv-reject-flow">
                        <p style={{ fontWeight: 600, marginBottom: '0.5rem', color: '#1f2937' }}>Please enter reason for rejection</p>
                        <input
                            type="text"
                            value={rejectReason}
                            onChange={e => setRejectReason(e.target.value)}
                            style={{ width: '100%', padding: '12px', borderRadius: '8px', border: '1px solid #d1d5db', marginBottom: '1rem', fontSize: '1rem', outline: 'none' }}
                            autoFocus
                        />
                        <div className="rv-actions">
                            <button className="rv-btn rv-btn--approve" style={{ background: '#9ca3af', boxShadow: 'none' }} onClick={handleCancelReject} disabled={processing}>
                                Cancel
                            </button>
                            <button className="rv-btn rv-btn--reject" onClick={handleConfirmReject} disabled={processing || !rejectReason.trim()}>
                                {processing ? <Loader2 size={18} className="rv-spin" /> : <XCircle size={18} />}
                                Confirm Reject
                            </button>
                        </div>
                    </div>
                ) : (
                    <div className="rv-actions">
                        <button className="rv-btn rv-btn--approve" onClick={handleApprove} disabled={processing}>
                            {processing ? <Loader2 size={18} className="rv-spin" /> : <CheckCircle2 size={18} />}
                            Approve Entry
                        </button>
                        <button className="rv-btn rv-btn--reject" onClick={handleRejectClick} disabled={processing}>
                            {processing ? <Loader2 size={18} className="rv-spin" /> : <XCircle size={18} />}
                            Reject Entry
                        </button>
                    </div>
                )}
                <p className="rv-security-note">🔒 This link is unique to you. Do not share it.</p>
            </div>
        </div>
    );
}

function InfoRow({ icon, label, value }) {
    return (
        <div className="rv-info-row">
            <span className="rv-info-icon">{icon}</span>
            <div className="rv-info-content">
                <span className="rv-info-label">{label}</span>
                <span className="rv-info-value">{value}</span>
            </div>
        </div>
    );
}
