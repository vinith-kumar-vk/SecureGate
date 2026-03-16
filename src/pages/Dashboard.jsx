import React, { useState } from 'react';
import { Chart as ChartJS, CategoryScale, LinearScale, PointElement, LineElement, Title, Tooltip as ChartTooltip, Legend, Filler, BarElement, ArcElement } from 'chart.js';
import { Line, Bar, Doughnut } from 'react-chartjs-2';
import { Users, Clock, CheckCircle, XCircle, Home, ShieldAlert, Zap, CheckSquare, Download, User, Search, Package, Filter } from 'lucide-react';
import AdminLayout from '../components/AdminLayout';
import { useNotification } from '../components/NotificationProvider';
import { apiService } from '../services/apiService';

ChartJS.register(CategoryScale, LinearScale, PointElement, LineElement, BarElement, ArcElement, Title, ChartTooltip, Legend, Filler);

export default function Dashboard() {
    const { addNotification } = useNotification();
    const [selectedVisitor, setSelectedVisitor] = useState(null);
    const [visitors, setVisitors] = useState([]);
    const [stats, setStats] = useState({ total: 0, waiting: 0, approved: 0, rejected: 0 });
    const [searchQuery, setSearchQuery] = useState('');
    const [statusFilter, setStatusFilter] = useState('all');

    React.useEffect(() => {
        const user = JSON.parse(localStorage.getItem('user') || '{}');
        const society_id = user.society_id;

        const fetchVisitors = async () => {
            try {
                const data = await apiService.getAllVisitors(society_id ? { society_id } : {});
                if (data.success) {
                    setVisitors(data.data);

                    // Calculate stats
                    const visitorsArr = Array.isArray(data.data) ? data.data : [];
                    const statsObj = visitorsArr.reduce((acc, v) => {
                        acc.total++;
                        if (v.status === 'waiting') acc.waiting++;
                        else if (v.status === 'approved') acc.approved++;
                        else if (v.status === 'denied') acc.rejected++;
                        return acc;
                    }, { total: 0, waiting: 0, approved: 0, rejected: 0 });
                    setStats(statsObj);
                }
            } catch (err) {
                console.error('Failed to fetch dashboard data:', err);
            }
        };

        fetchVisitors();
        const interval = setInterval(fetchVisitors, 5000); // Polling for live updates
        return () => clearInterval(interval);
    }, []);

    const trendData = {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            label: 'Visitors',
            data: [65, 59, 80, 81, 56, 120, 140],
            borderColor: '#FF5C2A',
            backgroundColor: 'rgba(255, 92, 42, 0.1)',
            tension: 0.4,
            fill: true,
        }]
    };

    const blockData = {
        labels: ['Block A', 'Block B', 'Block C', 'Block D'],
        datasets: [{ data: [40, 25, 20, 15], backgroundColor: ['#FF5C2A', '#10b981', '#f59e0b', '#8b5cf6'], borderWidth: 0 }]
    };

    const handleExport = () => {
        addNotification('Generating Comprehensive CSV Export...', 'loading', 2000);
        
        const headers = ["Visitor", "Phone", "Flat", "Purpose", "Entry Time", "Exit Time", "Status", "Guard"];
        const csvContent = [
            headers.join(','),
            ...visitors.map(v => [
                `"${v.name}"`,
                `"${v.phone}"`,
                `"${v.flat}"`,
                `"${v.purpose}"`,
                `"${v.timestamp}"`,
                `"${v.exit_time || '-'}"`,
                `"${v.status}"`,
                `"${v.guard || 'Ram Singh'}"`
            ].join(','))
        ].join('\n');

        const blob = new Blob([csvContent], { type: 'text/csv' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `SecureGate_Summary_${new Date().toISOString().split('T')[0]}.csv`;
        a.click();
        
        setTimeout(() => addNotification('Dashboard report exported successfully', 'success'), 2000);
    };

    const filteredVisitors = visitors.filter(v => {
        const matchesSearch = v.name?.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             v.flat?.toLowerCase().includes(searchQuery.toLowerCase()) ||
                             v.purpose?.toLowerCase().includes(searchQuery.toLowerCase());
        
        const matchesStatus = statusFilter === 'all' || v.status === statusFilter;
        
        return matchesSearch && matchesStatus;
    });

    return (
        <AdminLayout>
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', flexWrap: 'wrap', gap: '1rem', marginBottom: '1.5rem' }}>
                <div>
                    <h1 style={{ fontSize: '1.5rem', fontWeight: 700, margin: '0' }}>Overview Dashboard</h1>
                    <p style={{ margin: '0.25rem 0 0', color: 'var(--admin-text-muted)', fontSize: '0.875rem' }}>Monitor your real-time security operations.</p>
                </div>
                <button className="btn-secondary" onClick={handleExport}>
                    <Download size={16} /> Export Data
                </button>
            </div>

            <div className="stats-grid">
                {/* Stat cards remain same */}
                <div className="stat-card">
                    <div className="stat-header">
                        <div className="stat-icon purple"><Package size={20} /></div>
                        <div></div>
                    </div>
                    <div>
                        <div className="stat-title" style={{ color: '#7c3aed', marginBottom: '0.5rem' }}>Total Visitors</div>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            <div className="stat-value">{stats.total}</div>
                            <div style={{ color: '#22C55E', fontSize: '0.875rem', fontWeight: 600 }}>↗ +56%</div>
                        </div>
                    </div>
                    <div onClick={handleExport} style={{ borderTop: '1px solid var(--admin-border)', paddingTop: '1rem', marginTop: '0.5rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', fontSize: '0.875rem', color: 'var(--admin-text-muted)', cursor: 'pointer' }}>
                        Download report <Download size={14} />
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-header">
                        <div className="stat-icon orange"><Clock size={20} /></div>
                        <div></div>
                    </div>
                    <div>
                        <div className="stat-title" style={{ color: '#D97706', marginBottom: '0.5rem' }}>On Process</div>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            <div className="stat-value">{stats.waiting}</div>
                            <div style={{ color: '#22C55E', fontSize: '0.875rem', fontWeight: 600 }}>↗ +26%</div>
                        </div>
                    </div>
                    <div onClick={() => setStatusFilter(statusFilter === 'waiting' ? 'all' : 'waiting')} style={{ borderTop: '1px solid var(--admin-border)', paddingTop: '1rem', marginTop: '0.5rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', fontSize: '0.875rem', color: statusFilter === 'waiting' ? '#FF5C2A' : 'var(--admin-text-muted)', cursor: 'pointer', fontWeight: statusFilter === 'waiting' ? 600 : 400 }}>
                        {statusFilter === 'waiting' ? 'Showing Pending' : 'Filter Pending'} <Filter size={14} />
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-header">
                        <div className="stat-icon green"><CheckCircle size={20} /></div>
                        <div></div>
                    </div>
                    <div>
                        <div className="stat-title" style={{ color: '#22C55E', marginBottom: '0.5rem' }}>Approved Entry</div>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            <div className="stat-value">{stats.approved}</div>
                            <div style={{ color: '#22C55E', fontSize: '0.875rem', fontWeight: 600 }}>↗ +86%</div>
                        </div>
                    </div>
                    <div onClick={() => setStatusFilter(statusFilter === 'approved' ? 'all' : 'approved')} style={{ borderTop: '1px solid var(--admin-border)', paddingTop: '1rem', marginTop: '0.5rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', fontSize: '0.875rem', color: statusFilter === 'approved' ? '#10b981' : 'var(--admin-text-muted)', cursor: 'pointer', fontWeight: statusFilter === 'approved' ? 600 : 400 }}>
                        {statusFilter === 'approved' ? 'Showing Approved' : 'Filter Approved'} <Filter size={14} />
                    </div>
                </div>

                <div className="stat-card">
                    <div className="stat-header">
                        <div className="stat-icon red"><XCircle size={20} /></div>
                        <div></div>
                    </div>
                    <div>
                        <div className="stat-title" style={{ color: '#EF4444', marginBottom: '0.5rem' }}>Rejected / Denied</div>
                        <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between' }}>
                            <div className="stat-value">{stats.rejected}</div>
                            <div style={{ color: '#EF4444', fontSize: '0.875rem', fontWeight: 600 }}>↘ -12%</div>
                        </div>
                    </div>
                    <div onClick={() => setStatusFilter(statusFilter === 'denied' ? 'all' : 'denied')} style={{ borderTop: '1px solid var(--admin-border)', paddingTop: '1rem', marginTop: '0.5rem', display: 'flex', alignItems: 'center', justifyContent: 'center', gap: '0.5rem', fontSize: '0.875rem', color: statusFilter === 'denied' ? '#EF4444' : 'var(--admin-text-muted)', cursor: 'pointer', fontWeight: statusFilter === 'denied' ? 600 : 400 }}>
                        {statusFilter === 'denied' ? 'Showing Rejected' : 'Filter Rejected'} <Filter size={14} />
                    </div>
                </div>
            </div>

            <div className="charts-grid" style={{ marginTop: '1.5rem' }}>
                <div className="panel">
                    <div className="panel-header"><span className="panel-title">Weekly Trends</span></div>
                    <div className="panel-body" style={{ minHeight: '250px' }}><Line data={trendData} options={{ responsive: true, maintainAspectRatio: false }} /></div>
                </div>
                <div className="panel">
                    <div className="panel-header"><span className="panel-title">Block Traffic</span></div>
                    <div className="panel-body" style={{ minHeight: '250px' }}><Doughnut data={blockData} options={{ responsive: true, maintainAspectRatio: false }} /></div>
                </div>
            </div>

            <div className="panel" style={{ marginTop: '1.5rem', borderBottom: 'none' }}>
                <div className="panel-header" style={{ borderBottom: 'none', paddingBottom: '0.5rem' }}>
                    <div>
                        <span className="panel-title" style={{ fontSize: '1.25rem' }}>Review all visitor records</span>
                        <p style={{ margin: '0.25rem 0 0', fontSize: '0.875rem' }}>View detailed records of recent entry requests</p>
                    </div>
                </div>

                <div className="table-controls" style={{ padding: '1rem 1.5rem', borderBottom: 'none' }}>
                    <div className="search-bar">
                        <Search size={18} color="var(--admin-text-muted)" />
                        <input 
                            type="text" 
                            placeholder="Search for name, flat or purpose..." 
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                    </div>
                    <div className="actions-group">
                        <select 
                            className="btn-secondary" 
                            style={{ background: 'white', color: 'var(--admin-text-main)', border: '1px solid var(--admin-border)', boxShadow: 'none', padding: '0.5rem' }}
                            value={statusFilter}
                            onChange={(e) => setStatusFilter(e.target.value)}
                        >
                            <option value="all">All Status</option>
                            <option value="waiting">On Process</option>
                            <option value="approved">Completed</option>
                            <option value="denied">Canceled</option>
                        </select>
                        <button className="btn-secondary" onClick={handleExport}>
                            Export CSV
                        </button>
                    </div>
                </div>

                <div className="data-table-wrapper">
                    <table className="data-table" style={{ borderTop: '1px solid var(--admin-border)' }}>
                        <thead>
                            <tr>
                                <th>Visitor ↕</th>
                                <th>Flat ↕</th>
                                <th>Purpose ↕</th>
                                <th>Status ↕</th>
                                <th>Time ↕</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            {filteredVisitors.map(v => (
                                <tr key={v.id} onClick={() => setSelectedVisitor(v)}>
                                    <td style={{ fontWeight: 500 }}>{v.name}</td>
                                    <td><span className="badge badge-primary" style={{ background: '#FFF5F2', color: '#E64B20', borderRadius: '6px' }}>{v.flat}</span></td>
                                    <td>{v.purpose}</td>
                                    <td>
                                        <span className={`status-badge status-${v.status === 'denied' ? 'rejected' : (v.status || '').toLowerCase()}`}>
                                            {v.status === 'approved' ? 'Completed' : v.status === 'denied' ? 'Canceled' : 'On Process'}
                                        </span>
                                    </td>
                                    <td style={{ color: 'var(--admin-text-muted)' }}>{v.timestamp}</td>
                                    <td style={{ textAlign: 'right', color: 'var(--admin-text-muted)' }}>•••</td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </AdminLayout>
    );
}
