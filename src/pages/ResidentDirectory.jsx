import React, { useState, useEffect } from 'react';
import { useLocation } from 'react-router-dom';
import { Search, Plus, Edit, Trash2, MapPin, Filter, Filter as FilterIcon, ChevronUp, ChevronDown, CheckCircle, XCircle } from 'lucide-react';
import AdminLayout from '../components/AdminLayout';
import { useNotification } from '../components/NotificationProvider';

const initialResidents = [
    { id: 1, name: "Ramesh Kumar", flat: "A-101", phone: "+91 98765 00001", email: "ramesh.k@email.com", block: "Block A", moveIn: "2023-01-15", status: "Active", family: 4, vehicle: "MH01AB1234" },
    { id: 2, name: "Sneha Reddy", flat: "B-205", phone: "+91 87654 00002", email: "sneha.r@email.com", block: "Block B", moveIn: "2024-03-22", status: "Active", family: 2, vehicle: "TS09CD5678" },
    { id: 3, name: "Vikram Joshi", flat: "C-302", phone: "+91 76543 00003", email: "vikram.j@email.com", block: "Block C", moveIn: "2022-11-05", status: "Inactive", family: 3, vehicle: "KA05EF9012" },
    { id: 4, name: "Anita Sharma", flat: "D-105", phone: "+91 65432 00004", email: "anita.s@email.com", block: "Block D", moveIn: "2025-01-10", status: "Active", family: 1, vehicle: "" },
];

export default function ResidentDirectory() {
    const location = useLocation();
    const { addNotification } = useNotification();
    const [residents, setResidents] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [searchQuery, setSearchQuery] = useState('');
    const [blockFilter, setBlockFilter] = useState('All Blocks');

    const [isModalOpen, setIsModalOpen] = useState(false);
    const [modalMode, setModalMode] = useState('add');
    const [currentResident, setCurrentResident] = useState({
        id: null, name: '', flat_number: '', phone: '', email: '', block: 'Block A', moveIn: '', status: 'Active', family: 1, vehicle: ''
    });

    // Custom Confirm Modal State
    const [confirmDialog, setConfirmDialog] = useState({
        isOpen: false,
        title: '',
        message: '',
        onConfirm: null,
        type: 'danger',
        confirmText: 'Confirm'
    });
    const closeConfirmDialog = () => setConfirmDialog(prev => ({ ...prev, isOpen: false }));

    const fetchResidents = async () => {
        setIsLoading(true);
        try {
            const response = await fetch('/api/residents');
            const data = await response.json();
            if (data.success) {
                // Map DB field flat_number to UI field flat
                const mapped = data.data.map(r => ({
                    ...r,
                    flat: r.flat_number || '', // Backup for UI display
                    status: 'Active', // Default status for now
                    block: r.block || 'Block A'
                }));
                setResidents(mapped);
            }
        } catch (error) {
            addNotification('Failed to load residents', 'error');
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        fetchResidents();
        if (location.state && location.state.openAdd) {
            openAddModal();
            window.history.replaceState({}, document.title);
        }
    }, [location]);

    const openAddModal = () => {
        setModalMode('add');
        setCurrentResident({ id: null, name: '', flat_number: '', phone: '', email: '', block: 'Block A', moveIn: new Date().toISOString().split('T')[0], status: 'Active', family: 1, vehicle: '' });
        setIsModalOpen(true);
    };

    const openEditModal = (res) => {
        setModalMode('edit');
        setCurrentResident({ ...res, flat_number: res.flat });
        setIsModalOpen(true);
    };

    const deleteResident = (id) => {
        setConfirmDialog({
            isOpen: true,
            title: 'Remove Resident',
            message: 'Are you sure you want to remove this resident? This action cannot be undone.',
            type: 'danger',
            confirmText: 'Remove',
            onConfirm: async () => {
                try {
                    const response = await fetch(`/api/residents/${id}`, { method: 'DELETE' });
                    const result = await response.json();
                    if (result.success) {
                        setResidents(residents.filter(r => r.id !== id));
                        addNotification('Resident removed successfully', 'success');
                    } else {
                        addNotification(result.error || 'Failed to remove resident', 'error');
                    }
                } catch (error) {
                    addNotification('Server connection failed', 'error');
                }
            }
        });
    };

    const saveResident = async (e) => {
        e.preventDefault();
        addNotification(modalMode === 'add' ? 'Creating resident profile...' : 'Updating profile...', 'loading', 1500);

        try {
            const url = modalMode === 'add' ? '/api/residents' : `/api/residents/${currentResident.id}`;
            const method = modalMode === 'add' ? 'POST' : 'PUT';
            
            const response = await fetch(url, {
                method,
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(currentResident)
            });

            const result = await response.json();

            if (result.success) {
                await fetchResidents(); // Refresh the list from DB
                addNotification(modalMode === 'add' ? 'Resident added successfully!' : 'Profile updated successfully!', 'success');
                setIsModalOpen(false);
            } else {
                addNotification(result.error || 'Failed to save resident', 'error');
            }
        } catch (error) {
            addNotification('Server connection failed', 'error');
        }
    };

    const filtered = residents.filter(r =>
        (r.name.toLowerCase().includes(searchQuery.toLowerCase()) || (r.flat_number || '').toLowerCase().includes(searchQuery.toLowerCase())) &&
        (blockFilter === 'All Blocks' || r.block === blockFilter)
    );

    return (
        <AdminLayout>
            <div className="panel">
                <div className="panel-header">
                    <div>
                        <h1 className="panel-title">Resident Directory</h1>
                        <p style={{ margin: 0, color: 'var(--admin-text-muted)', fontSize: '0.875rem' }}>Total {residents.length} registered residents</p>
                    </div>
                    <button className="btn-primary" onClick={openAddModal}>
                        <Plus size={18} /> Add Resident
                    </button>
                </div>

                <div className="table-controls" style={{ padding: '1.25rem', borderBottom: '1px solid var(--admin-border)', display: 'flex', gap: '1rem' }}>
                    <div className="search-bar" style={{ flex: 1, maxWidth: '400px', border: '1px solid var(--admin-border)' }}>
                        <Search size={18} color="var(--admin-text-muted)" />
                        <input
                            type="text"
                            placeholder="Search name, flat or phone..."
                            value={searchQuery}
                            onChange={(e) => setSearchQuery(e.target.value)}
                        />
                    </div>
                    <select
                        className="filter-select"
                        value={blockFilter}
                        onChange={(e) => setBlockFilter(e.target.value)}
                    >
                        <option>All Blocks</option>
                        <option>Block A</option>
                        <option>Block B</option>
                        <option>Block C</option>
                        <option>Block D</option>
                    </select>
                </div>

                <div className="data-table-wrapper">
                    <table className="data-table">
                        <thead>
                            <tr>
                                <th>Resident Name</th>
                                <th>Flat</th>
                                <th>Contact Info</th>
                                <th>Family</th>
                                <th>Status</th>
                                <th style={{ textAlign: 'right' }}>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {filtered.map(res => (
                                <tr key={res.id}>
                                    <td>
                                        <div style={{ display: 'flex', alignItems: 'center', gap: '0.75rem' }}>
                                            <div className="avatar" style={{ width: '32px', height: '32px', fontSize: '0.9rem' }}>{res.name.charAt(0)}</div>
                                            <div style={{ fontWeight: 600 }}>{res.name}</div>
                                        </div>
                                    </td>
                                    <td><span className="flat-badge">{res.flat_number || res.flat}</span></td>
                                    <td>
                                        <div style={{ fontSize: '0.875rem' }}>{res.phone}</div>
                                        <div style={{ fontSize: '0.75rem', color: 'var(--admin-text-muted)' }}>{res.email}</div>
                                    </td>
                                    <td style={{ color: 'var(--admin-text-muted)' }}>{res.family || '-'} Members</td>
                                    <td>
                                        <span className={`status-badge status-${res.status.toLowerCase()}`}>
                                            <div className="status-dot"></div>
                                            {res.status}
                                        </span>
                                    </td>
                                    <td style={{ textAlign: 'right' }}>
                                        <div style={{ display: 'flex', gap: '0.5rem', justifyContent: 'flex-end' }}>
                                            <button className="action-btn" onClick={() => openEditModal(res)} title="Edit"><Edit size={18} color="var(--admin-primary)" /></button>
                                            <button className="action-btn" onClick={() => deleteResident(res.id)} title="Delete"><Trash2 size={18} color="var(--admin-error)" /></button>
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>

            {/* Modal */}
            {isModalOpen && (
                <div className="modal-overlay" onClick={() => setIsModalOpen(false)}>
                    <div className="modal-content" onClick={e => e.stopPropagation()} style={{ maxWidth: '500px' }}>
                        <div className="modal-header">
                            <h3>{modalMode === 'add' ? 'Add New Resident' : 'Edit Resident Profile'}</h3>
                        </div>
                        <form onSubmit={saveResident}>
                            <div className="modal-body" style={{ display: 'grid', gridTemplateColumns: '1fr 1fr', gap: '1rem' }}>
                                <div style={{ gridColumn: 'span 2' }}>
                                    <label className="input-label">Full Name</label>
                                    <input className="input-field" style={{ border: '1px solid var(--admin-border)' }} required value={currentResident.name} onChange={e => setCurrentResident({ ...currentResident, name: e.target.value })} />
                                </div>
                                <div>
                                    <label className="input-label">Flat Number</label>
                                    <input className="input-field" style={{ border: '1px solid var(--admin-border)' }} required value={currentResident.flat_number} onChange={e => setCurrentResident({ ...currentResident, flat_number: e.target.value })} />
                                </div>
                                <div>
                                    <label className="input-label">Block</label>
                                    <select className="input-field" style={{ border: '1px solid var(--admin-border)' }} value={currentResident.block} onChange={e => setCurrentResident({ ...currentResident, block: e.target.value })}>
                                        <option>Block A</option><option>Block B</option><option>Block C</option><option>Block D</option>
                                    </select>
                                </div>
                                <div style={{ gridColumn: 'span 2' }}>
                                    <label className="input-label">Email Address</label>
                                    <input className="input-field" style={{ border: '1px solid var(--admin-border)' }} required type="email" value={currentResident.email} onChange={e => setCurrentResident({ ...currentResident, email: e.target.value })} />
                                </div>
                                <div style={{ gridColumn: 'span 2' }}>
                                    <label className="input-label">Phone Number</label>
                                    <input className="input-field" style={{ border: '1px solid var(--admin-border)' }} required value={currentResident.phone} onChange={e => setCurrentResident({ ...currentResident, phone: e.target.value })} />
                                </div>
                            </div>
                            <div className="modal-footer">
                                <button type="button" className="btn-secondary" onClick={() => setIsModalOpen(false)}>Cancel</button>
                                <button type="submit" className="btn-primary">Save Resident</button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
            {/* Confirm Modal */}
            {confirmDialog.isOpen && (
                <div className="modal-overlay" style={{ zIndex: 1100 }}>
                    <div className="modal-content" style={{ maxWidth: '400px' }}>
                        <div className="modal-header" style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: '1rem' }}>
                            <h3 style={{ margin: 0 }}>{confirmDialog.title}</h3>
                            <button onClick={closeConfirmDialog} className="action-btn" style={{ padding: 0 }}><XCircle size={20} color="var(--admin-text-muted)" /></button>
                        </div>
                        <div className="modal-body">
                            <p style={{ margin: 0, fontSize: '0.95rem', color: 'var(--admin-text)' }}>{confirmDialog.message}</p>
                        </div>
                        <div className="modal-footer" style={{ display: 'flex', justifyContent: 'flex-end', gap: '0.75rem', marginTop: '1.5rem', paddingTop: '1.5rem', borderTop: '1px solid var(--admin-border)' }}>
                            <button type="button" onClick={closeConfirmDialog} className="btn-secondary">Cancel</button>
                            <button 
                                type="button" 
                                onClick={() => {
                                    confirmDialog.onConfirm();
                                    closeConfirmDialog();
                                }} 
                                className="btn-primary"
                                style={confirmDialog.type === 'danger' ? { background: 'var(--admin-error)' } : {}}
                            >
                                {confirmDialog.confirmText}
                            </button>
                        </div>
                    </div>
                </div>
            )}
        </AdminLayout>
    );
}
