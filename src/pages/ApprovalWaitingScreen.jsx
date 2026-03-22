import React, { useEffect, useState, useRef } from 'react';
import { useNavigate, useLocation } from 'react-router-dom';
import { ShieldCheck, Loader2, CheckCircle2, XCircle, Camera, CameraOff, Eye, Home, Clock } from 'lucide-react';
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

    // Animated dots
    useEffect(() => {
        const id = setInterval(() => setDots(d => d.length >= 3 ? '' : d + '.'), 500);
        return () => clearInterval(id);
    }, []);

    // Polling logic 
    useEffect(() => {
        if (!requestId) return;

        const pollInterval = setInterval(async () => {
            try {
                const response = await apiService.getVisitorStatus(requestId);
                if (response.success) {
                    const latestStatus = response.status;
                    if (latestStatus === 'approved' || latestStatus === 'denied') {
                        setStatus(latestStatus);
                        if (response.reason) setDenialReason(response.reason);
                        clearInterval(pollInterval); // 
                    }
                }
            } catch (error) {
                console.error("Status check failed:", error);
            }
        }, 3000);

        // Camera setup (Optional but good for visual)
        const setupCamera = async () => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia({ video: true });
                streamRef.current = stream;
                if (videoRef.current) videoRef.current.srcObject = stream;
            } catch (err) {
                setCameraError(true);
            }
        };
        setupCamera();

        return () => {
            clearInterval(pollInterval);
            streamRef.current?.getTracks().forEach(t => t.stop());
        };
    }, [requestId]);

    useEffect(() => {
        if (status === 'approved') {
            streamRef.current?.getTracks().forEach(t => t.stop());
            apiService.openGate();
            const timer = setTimeout(() => navigate('/'), 10000);
            return () => clearTimeout(timer);
        }
        if (status === 'denied') {
            streamRef.current?.getTracks().forEach(t => t.stop());
            const timer = setTimeout(() => navigate('/'), 12000);
            return () => clearTimeout(timer);
        }
    }, [status, navigate]);

    if (status === 'approved') {
        return (
            <div className="waiting-page">
                <div className="waiting-card outcome-card approved-card">
                    <div className="outcome-icon-wrap approved">
                        <CheckCircle2 size={56} color="#10b981" />
                    </div>
                    <h1 className="outcome-title approved-title">Access Approved. Welcome.</h1>
                    <p className="outcome-subtitle">Gate opening...</p>
                    <div className="outcome-info-box approved-info">
                        <ShieldCheck size={16} />
                        <span>Identity verified by resident — proceed to the gate</span>
                    </div>
                </div>
            </div>
        );
    }

    if (status === 'denied') {
        return (
            <div className="waiting-page">
                <div className="waiting-card outcome-card denied-card">
                    <div className="outcome-icon-wrap denied">
                        <XCircle size={56} color="#ef4444" />
                    </div>
                    <h1 className="outcome-title denied-title">Access Denied</h1>
                    <p className="outcome-subtitle">Rejected by resident.</p>
                    <div className="denial-reason-text">{denialReason}</div>
                </div>
            </div>
        );
    }

    return (
        <div className="waiting-page">
            <div className="waiting-card">
                <div className="camera-section">
                    <div className="camera-frame">
                        {cameraError ? <CameraOff /> : <video ref={videoRef} autoPlay playsInline muted style={{ width: '100%' }} />}
                        <div className="live-badge">LIVE</div>
                    </div>
                </div>
                <div className="waiting-status">
                    <h2 className="waiting-title">Waiting for Approval{dots}</h2>
                    <p>Sent to Flat <strong>{visitorFlat}</strong></p>
                </div>
            </div>
        </div>
    );
}
