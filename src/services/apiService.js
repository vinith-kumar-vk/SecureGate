/* SecureGate — API Service
   Connects to the Laravel backend(Proxied via Vite)
   Falls back gracefully if the server is not running.
   ================================================================ */

const BASE_URL = '/api';

async function request(method, path, body = null) {
    try {
        const opts = {
            method,
            headers: { 'Content-Type': 'application/json' },
        };
        if (body) opts.body = JSON.stringify(body);
        const res = await fetch(`${BASE_URL}${path}`, opts);
        const json = await res.json();
        if (!res.ok) throw new Error(json.message || `Server error ${res.status}`);
        return json;
    } catch (err) {
        // Network error — backend probably not running
        if (err.name === 'TypeError' && err.message.includes('fetch')) {
            throw new Error('Laravel Backend server not reachable. Please run: php artisan serve');
        }
        throw err;
    }
}

export const apiService = {
    /* ── Visitor Registration ──────────────────────────────────
       POST /api/register
       Returns { requestId, approvalLink, smsStatus }            */
    async registerVisitor(data) {
        return request('POST', '/register', {
            name: data.name,
            phone: data.phone,
            flat: data.flat,
            purpose: data.purpose,
        });
    },

    /* ── Poll for status (visitor waiting screen) ──────────────
       GET /api/status/:id
       Returns { status: 'waiting' | 'approved' | 'denied' }     */
    async checkRequestStatus(requestId) {
        return request('GET', `/status/${requestId}`);
    },

    /* ── Get visitor details (resident verification page) ───────
       GET /api/request/:id                                       */
    async getRequestDetails(requestId) {
        return request('GET', `/request/${requestId}`);
    },

    /* ── Resident approves visitor ─────────────────────────────
       POST /api/approve/:id                                      */
    async approveVisitor(requestId) {
        return request('POST', `/approve/${requestId}`);
    },

    /* ── Resident rejects visitor ──────────────────────────────
       POST /api/reject/:id                                       */
    async rejectVisitor(requestId, reason = '') {
        return request('POST', `/reject/${requestId}`, { reason });
    },

    /* ── Legacy stubs (kept for other pages) ────────────────── */
    async verifyOTP(otp) {
        await new Promise(r => setTimeout(r, 1000));
        if (otp === '1234') return { success: true, message: 'OTP Verified.' };
        throw new Error('Invalid OTP');
    },

    async verifyQR() {
        await new Promise(r => setTimeout(r, 1000));
        return { success: true, message: 'QR Code Verified.' };
    },

    async openGate() {
        await new Promise(r => setTimeout(r, 1500));
        return { success: true, message: 'Gate Opened.' };
    },

    async recordExit() {
        await new Promise(r => setTimeout(r, 800));
        return { success: true, message: 'Exit recorded.' };
    },
};
