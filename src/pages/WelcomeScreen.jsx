import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import { ShieldCheck, ArrowRight, Clock } from 'lucide-react';

export default function WelcomeScreen() {
    const navigate = useNavigate();
    const [time, setTime] = useState(new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));

    useEffect(() => {
        const timer = setInterval(() => {
            setTime(new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }));
        }, 10000);
        return () => clearInterval(timer);
    }, []);

    return (
        <div className="welcome-wrapper">
            <style>
                {`
                    .welcome-wrapper {
                        min-height: 100vh;
                        width: 100vw;
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        background: #ffffff;
                        position: relative;
                        font-family: 'Inter', system-ui, sans-serif;
                        padding: 1.5rem;
                        box-sizing: border-box;
                        overflow: hidden;
                    }
                    .welcome-wrapper::before {
                        content: '';
                        position: absolute;
                        top: 0; left: 0; right: 0; bottom: 0;
                        background-image: radial-gradient(#e2e8f0 1.5px, transparent 1.5px);
                        background-size: 32px 32px;
                        opacity: 0.25;
                        pointer-events: none;
                    }
                    .welcome-card {
                        background: rgba(255, 255, 255, 0.85);
                        backdrop-filter: blur(20px);
                        -webkit-backdrop-filter: blur(20px);
                        border: 1px solid rgba(255, 255, 255, 0.8);
                        border-radius: 24px;
                        padding: 3.5rem 2.5rem;
                        max-width: 520px;
                        width: 100%;
                        box-shadow: 0 20px 40px -10px rgba(37, 99, 235, 0.1), 
                                    inset 0 1px 0 rgba(255, 255, 255, 1);
                        display: flex;
                        flex-direction: column;
                        align-items: center;
                        text-align: center;
                        animation: cardFadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
                        position: relative;
                        z-index: 10;
                        transition: transform 0.3s ease, box-shadow 0.3s ease;
                    }
                    .welcome-card:hover {
                        transform: translateY(-4px);
                        box-shadow: 0 25px 50px -12px rgba(37, 99, 235, 0.15), 
                                    inset 0 1px 0 rgba(255, 255, 255, 1);
                    }
                    @keyframes cardFadeIn {
                        from { opacity: 0; transform: translateY(30px); }
                        to { opacity: 1; transform: translateY(0); }
                    }
                    .time-display {
                        position: absolute;
                        top: 1.5rem;
                        right: 1.5rem;
                        font-size: 0.9rem;
                        font-weight: 600;
                        color: #64748b;
                        background: rgba(241, 245, 249, 0.8);
                        padding: 0.5rem 0.875rem;
                        border-radius: 999px;
                        display: flex;
                        align-items: center;
                        gap: 0.4rem;
                        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
                        border: 1px solid rgba(255, 255, 255, 0.4);
                    }
                    .shield-container {
                        width: 80px;
                        height: 80px;
                        background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%);
                        border-radius: 24px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        box-shadow: 0 8px 16px rgba(37, 99, 235, 0.12),
                                    inset 0 2px 4px rgba(255, 255, 255, 0.9);
                        border: 1px solid rgba(191, 219, 254, 0.8);
                        margin-bottom: 2.25rem;
                        animation: pulseShield 2.5s infinite cubic-bezier(0.66, 0, 0, 1);
                        position: relative;
                    }
                    .shield-container::after {
                        content: '';
                        position: absolute;
                        inset: -4px;
                        border-radius: 28px;
                        background: radial-gradient(circle, rgba(59,130,246,0.15), transparent 70%);
                        z-index: -1;
                        pointer-events: none;
                    }
                    @keyframes pulseShield {
                        0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.3); }
                        70% { box-shadow: 0 0 0 20px rgba(37, 99, 235, 0); }
                        100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
                    }
                    .sg-subtitle {
                        font-size: 0.75rem;
                        font-weight: 700;
                        color: #3b82f6;
                        letter-spacing: 0.18em;
                        text-transform: uppercase;
                        margin-bottom: 1.5rem;
                        background: linear-gradient(90deg, #2563eb, #3b82f6);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                    }
                    .sg-main-title {
                        font-size: 2.5rem;
                        font-weight: 800;
                        color: #111827;
                        letter-spacing: -0.03em;
                        margin: 0 0 1.5rem 0;
                        line-height: 1.25;
                    }
                    .sg-description {
                        font-size: 1.15rem;
                        color: #4b5563;
                        line-height: 1.5;
                        margin-bottom: 3.5rem;
                        max-width: 420px;
                        font-weight: 400;
                    }
                    .start-btn {
                        width: 100%;
                        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
                        color: #ffffff;
                        border: none;
                        padding: 1.25rem 1rem;
                        border-radius: 999px;
                        font-size: 1.05rem;
                        font-weight: 700;
                        cursor: pointer;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        gap: 0.75rem;
                        box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35),
                                    inset 0 1px 0 rgba(255, 255, 255, 0.2);
                        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                        letter-spacing: 0.05em;
                        position: relative;
                        overflow: hidden;
                    }
                    .start-btn::after {
                        content: '';
                        position: absolute;
                        top: 0; left: -100%; width: 50%; height: 100%;
                        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
                        transform: skewX(-20deg);
                        animation: sheenSweep 4s infinite;
                    }
                    @keyframes sheenSweep {
                        0% { left: -100%; }
                        20% { left: 200%; }
                        100% { left: 200%; }
                    }
                    .start-btn:hover {
                        transform: scale(1.02) translateY(-2px);
                        box-shadow: 0 14px 30px rgba(37, 99, 235, 0.45),
                                    inset 0 1px 0 rgba(255, 255, 255, 0.3);
                        background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
                    }
                    .start-btn:active {
                        transform: scale(0.98) translateY(1px);
                        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
                    }
                    .start-btn:hover .arrow-icon {
                        animation: slideArrow 1s infinite ease-in-out;
                    }
                    @keyframes slideArrow {
                        0% { transform: translateX(0); }
                        50% { transform: translateX(4px); }
                        100% { transform: translateX(0); }
                    }
                    @media (max-width: 480px) {
                        .welcome-card { padding: 3rem 1.5rem 2.5rem; margin: 1rem; }
                        .sg-main-title { font-size: 2rem; margin-bottom: 1.25rem; }
                        .sg-subtitle { margin-bottom: 1.25rem; }
                        .sg-description { font-size: 1.05rem; margin-bottom: 3rem; }
                        .start-btn { font-size: 1rem; padding: 1.15rem 1rem; }
                    }
                `}
            </style>

            <div className="welcome-card">
                <div className="time-display">
                    <Clock size={16} /> {time}
                </div>

                <div className="shield-container">
                    <ShieldCheck size={44} color="#2563eb" strokeWidth={1.5} />
                </div>

                <div className="sg-subtitle">SMART VISITOR ACCESS SYSTEM</div>

                <h1 className="sg-main-title">Welcome to SecureGate</h1>

                <p className="sg-description">
                    Tap below to securely register your visit and request resident approval.
                </p>

                <button
                    className="start-btn"
                    onClick={() => navigate('/register')}
                >
                    START VISITOR ENTRY
                    <ArrowRight className="arrow-icon" size={20} strokeWidth={2.5} />
                </button>
            </div>

            {/* Hidden admin link */}
            <div
                style={{ position: 'fixed', bottom: '1rem', right: '1rem', color: 'transparent', cursor: 'pointer', fontSize: '0.75rem', zIndex: 50, userSelect: 'none' }}
                onClick={() => navigate('/admin-login')}
            >
                Admin
            </div>
        </div>
    );
}
