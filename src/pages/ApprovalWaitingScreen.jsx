import React, { useEffect, useState, useRef } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { ShieldCheck, Loader2, CheckCircle2, XCircle, Camera, CameraOff, Eye, Home, Clock } from 'lucide-react';
import { io } from 'socket.io-client';
import { apiService } from '../services/apiService';
import '../styles/visitor-form.css';
import '../styles/waiting-screen.css';

export default function ApprovalWaitingScreen() {
    const navigate = useNavigate();
    const location = useLocation();

    const visitorFlat = location.state?.flat || 'A-101';
    const requestId = location.state?.requestId;

    const [status, setStatus] = useState('waiting');
    const [denialReason, setDenialReason] = useState('');
    const [cameraError, setCameraError] = useState(false);
    const [dots, setDots] = useState('');

    const videoRef = useRef(null);
    const streamRef = useRef(null);
    const socketRef = useRef(null);
    const peerRef = useRef(null);

    // Animated dots
    useEffect(() => {
        const id = setInterval(() => setDots(d => d.length >= 3 ? '' : d + '.'), 500);
        return () => clearInterval(id);
    }, []);

    // Set up WebRTC and Socket
    useEffect(() => {
        if (!requestId) {
            const t = setTimeout(() => setStatus('approved'), 8000);
            return () => clearTimeout(t);
        }

        const socket = io('/');
        socketRef.current = socket;
        socket.emit('join-room', requestId);

        socket.on('status-update', (data) => {
            if (data.status === 'approved' || data.status === 'denied') {
                setStatus(data.status);
                if (data.reason) setDenialReason(data.reason);
            }
        });

        const setupWebRTC = async () => {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                console.error("MediaDevices not supported. Use HTTPS!");
                setCameraError(true);
                return;
            }
            try {
                let stream = window.lastActiveStream;
                const isDead = !stream || stream.getTracks().every(t => t.readyState === 'ended');

                if (isDead) {
                    window.cameraPromise = navigator.mediaDevices.getUserMedia({
                        video: { facingMode: 'user', width: { ideal: 640 }, height: { ideal: 480 } }
                    });
                    try {
                        stream = await window.cameraPromise;
                        window.lastActiveStream = stream;
                    } catch (e) {
                        window.cameraPromise = null;
                        throw e;
                    }
                }

                streamRef.current = stream;
                if (videoRef.current) {
                    videoRef.current.srcObject = stream;
                }

                socket.emit('visitor-ready', requestId);

                socket.on('resident-joined', async () => {
                    if (peerRef.current) peerRef.current.close();

                    const peer = new RTCPeerConnection({ iceServers: [{ urls: 'stun:stun.l.google.com:19302' }] });
                    peerRef.current = peer;

                    stream.getTracks().forEach(track => peer.addTrack(track, stream));

                    peer.onicecandidate = (event) => {
                        if (event.candidate) {
                            socket.emit('ice-candidate', { roomId: requestId, candidate: event.candidate });
                        }
                    };

                    const offer = await peer.createOffer();
                    await peer.setLocalDescription(offer);
                    socket.emit('offer', { roomId: requestId, offer });
                });

                socket.on('answer', async (answer) => {
                    if (peerRef.current) {
                        try { await peerRef.current.setRemoteDescription(new RTCSessionDescription(answer)); } catch (e) { }
                    }
                });

                socket.on('ice-candidate', async (candidate) => {
                    if (peerRef.current) {
                        try { await peerRef.current.addIceCandidate(new RTCIceCandidate(candidate)); } catch (e) { }
                    }
                });

            } catch (err) {
                console.error("Camera access failed", err);
                setCameraError(true);
            }
        };

        setupWebRTC();

        return () => {
            streamRef.current?.getTracks().forEach(t => t.stop());
            socket.disconnect();
            peerRef.current?.close();
        };
    }, [requestId]);

    useEffect(() => {
        if (status === 'approved') {
            streamRef.current?.getTracks().forEach(t => t.stop());
            apiService.openGate(); // Trigger mock gate hardware
            // Stay on this success screen for 10 seconds, then return home
            const timer = setTimeout(() => navigate('/'), 10000);
            return () => clearTimeout(timer);
        }
        if (status === 'denied') {
            streamRef.current?.getTracks().forEach(t => t.stop());
            // Stay on denial screen for 12 seconds to ensure visibility, then return home
            const timer = setTimeout(() => navigate('/'), 12000);
            return () => clearTimeout(timer);
        }
    }, [status, navigate, location.state]);

    if (status === 'approved') {
        return (
            <div className="waiting-page">
                <div className="waiting-card outcome-card approved-card">
                    <div className="outcome-icon-wrap approved">
                        <div className="pulse-ring" />
                        <div className="pulse-ring delay" />
                        <CheckCircle2 size={56} color="#10b981" className="outcome-icon" />
                    </div>
                    <h1 className="outcome-title approved-title">Access Approved. Welcome.</h1>
                    <p className="outcome-subtitle">Gate opening...</p>
                    <div className="gate-animation">
                        <div className="gate-left" />
                        <div className="gate-right" />
                        <span className="gate-label">GATE OPENING</span>
                    </div>
                    <div className="outcome-info-box approved-info">
                        <ShieldCheck size={16} />
                        <span>Identity verified by resident — proceed to the gate</span>
                    </div>
                    <p className="outcome-redirect">Returning to home screen{dots}</p>
                </div>
            </div>
        );
    }

    if (status === 'denied') {
        return (
            <div className="waiting-page">
                <div className="waiting-card outcome-card denied-card">
                    <div className="outcome-icon-wrap denied">
                        <XCircle size={56} color="#ef4444" className="outcome-icon" />
                    </div>
                    <h1 className="outcome-title denied-title">Access Denied</h1>
                    <p className="outcome-subtitle">Your entry request was rejected by the resident.</p>

                    <div className="denial-reason-container">
                        <label className="denial-label">REASON FOR REJECTION:</label>
                        <div className="denial-reason-text">
                            {denialReason || "No specific reason provided by resident."}
                        </div>
                    </div>

                    <div className="outcome-info-box denied-info">
                        <Clock size={16} />
                        <span>Please contact the resident or security for assistance.</span>
                    </div>
                    <p className="outcome-redirect">Returning to home screen{dots}</p>
                </div>
            </div>
        );
    }

    return (
        <div className="waiting-page">
            <div className="waiting-card">
                <div className="waiting-badge">
                    <Loader2 size={13} className="badge-spinner" />
                    <span>Awaiting Resident Approval</span>
                </div>
                <div className="camera-section">
                    <div className="camera-frame">
                        {cameraError ? (
                            <div className="camera-error">
                                <CameraOff size={32} color="#94a3b8" />
                                <span>Camera unavailable</span>
                            </div>
                        ) : (
                            <video ref={videoRef} autoPlay playsInline muted className="camera-video" />
                        )}
                        {!cameraError && (
                            <div className="live-badge">
                                <span className="live-dot" />
                                LIVE
                            </div>
                        )}
                        <div className="corner tl" /><div className="corner tr" />
                        <div className="corner bl" /><div className="corner br" />
                    </div>
                    <div className="camera-instruction">
                        <Eye size={14} />
                        <span>Please stand in front of the camera and look clearly.</span>
                    </div>
                </div>
                <div className="waiting-status">
                    <h2 className="waiting-title">Waiting for Approval{dots}</h2>
                    <p className="waiting-desc">
                        Your entry request has been sent to the resident at <strong>Flat {visitorFlat}</strong>.
                    </p>
                </div>
                <div className="waiting-instructions">
                    <div className="instruction-item">
                        <div className="instruction-num">1</div>
                        <span>Stand in front of the camera and face forward</span>
                    </div>
                    <div className="instruction-item">
                        <div className="instruction-num">2</div>
                        <span>The resident is reviewing your identity via live feed</span>
                    </div>
                    <div className="instruction-item">
                        <div className="instruction-num">3</div>
                        <span>Do not move away — wait for the gate to open</span>
                    </div>
                </div>
                <div className="waiting-meta">
                    <div className="meta-chip">
                        <Home size={13} />
                        <span>Flat {visitorFlat}</span>
                    </div>
                    <div className="meta-chip">
                        <Clock size={13} />
                        <span>{new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })}</span>
                    </div>
                </div>
            </div>
        </div>
    );
}
