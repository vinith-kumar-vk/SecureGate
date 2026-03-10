const axios = require('axios');

async function test() {
    try {
        const res = await axios.post(
            'https://www.fast2sms.com/dev/bulkV2',
            {
                route: 'q',
                message: 'Test message from SecureGate setup',
                language: 'english',
                flash: 0,
                numbers: '9345272947',
            },
            {
                headers: {
                    authorization: 'fDZnKq5MQEVcmgsle03bYjCXPxA2GHRThav7WBFrNukywti9zO53oDmSbgL8NnvPjtpO0z24iEQqVITG',
                    'Content-Type': 'application/json',
                }
            }
        );
        console.log("SUCCESS:", res.data);
    } catch (err) {
        console.error("ERROR:", err.response?.data || err.message);
    }
}
test();
