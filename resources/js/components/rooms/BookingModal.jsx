import React, { useState, useCallback, useEffect, useRef } from 'react';
import { createPortal } from 'react-dom';

const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const JURUSAN_OPTIONS = [
    'Budidaya Tanaman Pangan',
    'Budidaya Tanaman Perkebunan',
    'Teknologi Pertanian',
    'Peternakan',
    'Ekonomi dan Bisnis',
    'Teknik',
    'Perikanan dan Kelautan',
    'Teknologi Informasi',
];

const TIME_SLOTS_START = Array.from({ length: 11 }, (_, i) => String(i + 7).padStart(2, '0') + ':00');
const TIME_SLOTS_END = Array.from({ length: 11 }, (_, i) => String(i + 8).padStart(2, '0') + ':00');

export default function BookingModal({ isOpen, onClose, roomId, currentDate, prodis }) {
    const [form, setForm] = useState({
        booker_name: '',
        booker_email: '',
        booker_phone: '',
        jurusan: '',
        prodi_id: '',
        purpose: '',
        mata_kuliah: '',
        semester: '',
        kelas: '',
        dosen: '',
        teknisi: '',
        date: currentDate,
        start_time: '',
        end_time: '',
        is_recurring: false,
        recurrence_count: '',
        notes: '',
    });

    const [filteredProdis, setFilteredProdis] = useState(prodis);
    const [showConflict, setShowConflict] = useState(false);
    const [conflicts, setConflicts] = useState([]);
    const [recurrenceDates, setRecurrenceDates] = useState([]);
    const [showRecurrencePreview, setShowRecurrencePreview] = useState(false);
    const [openedAt, setOpenedAt] = useState(0);

    useEffect(() => {
        if (isOpen) {
            setOpenedAt(Math.floor(Date.now() / 1000));
        }
    }, [isOpen]);

    useEffect(() => {
        if (!form.jurusan) {
            setFilteredProdis(prodis);
        } else {
            setFilteredProdis(prodis.filter(p => p.jurusan === form.jurusan));
        }
    }, [form.jurusan, prodis]);

    useEffect(() => {
        if (form.date && form.start_time && form.end_time && form.start_time < form.end_time) {
            const timeoutId = setTimeout(() => {
                fetch(`/rooms/${roomId}/check-availability?date=${form.date}&start_time=${form.start_time}&end_time=${form.end_time}`)
                    .then(res => res.json())
                    .then(data => {
                        setShowConflict(!data.available);
                        setConflicts(data.conflicts || []);
                    })
                    .catch(() => {
                        setShowConflict(false);
                        setConflicts([]);
                    });
            }, 300);
            return () => clearTimeout(timeoutId);
        } else {
            setShowConflict(false);
            setConflicts([]);
        }
    }, [form.date, form.start_time, form.end_time, roomId]);

    useEffect(() => {
        if (form.is_recurring && form.date && form.recurrence_count) {
            const start = new Date(form.date + 'T00:00:00');
            const count = Number(form.recurrence_count);
            const dates = [];
            for (let i = 0; i < count; i++) {
                const d = new Date(start);
                d.setDate(start.getDate() + i * 7);
                dates.push(d);
            }
            setRecurrenceDates(dates);
            setShowRecurrencePreview(dates.length > 0);
        } else {
            setRecurrenceDates([]);
            setShowRecurrencePreview(false);
        }
    }, [form.is_recurring, form.date, form.recurrence_count]);

    const handleChange = useCallback((e) => {
        const { name, value, type, checked } = e.target;
        setForm(prev => ({
            ...prev,
            [name]: type === 'checkbox' ? checked : value,
        }));
    }, []);

    const handleSubmit = useCallback((e) => {
        e.preventDefault();
        if (showConflict) return;
        e.target.submit();
    }, [showConflict]);

    const recurrenceDay = form.date ? DAY_NAMES[new Date(form.date + 'T00:00:00').getDay()] : '-';

    const recurrenceEndDate = form.is_recurring && form.date && form.recurrence_count
        ? (() => {
            const start = new Date(form.date + 'T00:00:00');
            start.setDate(start.getDate() + (Number(form.recurrence_count) - 1) * 7);
            return `${start.getFullYear()}-${String(start.getMonth() + 1).padStart(2, '0')}-${String(start.getDate()).padStart(2, '0')}`;
        })()
        : '';

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50" aria-modal="true" role="dialog">
            <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={onClose} />
            <div className="absolute inset-0 flex items-center justify-center p-4">
                <div className="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto scrollbar-hide">
                    <div className="sticky top-0 z-10 rounded-t-2xl bg-white/60 backdrop-blur-lg border-b border-white/40">
                        <div className="flex items-center justify-center relative p-5">
                            <div className="text-center">
                                <h2 className="text-lg font-bold text-gray-900">Form Peminjaman</h2>
                                <p className="text-sm text-gray-500 mt-0.5">Isi data diri untuk melakukan booking</p>
                            </div>
                            <button type="button" onClick={onClose} className="absolute right-5 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <CloseIcon />
                            </button>
                        </div>
                    </div>

                    <form action="/bookings" method="POST" onSubmit={handleSubmit} className="p-5 pt-2 space-y-4">
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                        <input type="hidden" name="room_id" value={roomId} />

                        <input type="text" name="website_url" tabIndex="-1" autoComplete="off"
                            style={{ position: 'absolute', left: '-9999px', opacity: 0, height: 0, width: 0 }}
                            aria-hidden="true" />
                        <input type="hidden" name="opened_at" value={openedAt} />

                        <div className="grid grid-cols-2 gap-3">
                            <FloatingField label="Nama Lengkap" required value={form.booker_name}>
                                <input type="text" name="booker_name" value={form.booker_name} onChange={handleChange} required
                                    className={inputCls} />
                            </FloatingField>
                            <FloatingField label="Email" required value={form.booker_email}>
                                <input type="email" name="booker_email" value={form.booker_email} onChange={handleChange} required
                                    className={inputCls} />
                            </FloatingField>
                        </div>

                        <FloatingField label="No. WhatsApp" required value={form.booker_phone}>
                            <input type="tel" name="booker_phone" value={form.booker_phone} onChange={handleChange} required
                                className={inputCls} />
                        </FloatingField>

                        <div className="grid grid-cols-2 gap-3">
                            <FloatingField label="Jurusan" required value={form.jurusan} isDropdown>
                                <select name="jurusan" value={form.jurusan} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    {JURUSAN_OPTIONS.map(j => <option key={j} value={j}>{j}</option>)}
                                </select>
                            </FloatingField>
                            <FloatingField label="Prodi" required value={form.prodi_id} isDropdown>
                                <select name="prodi_id" value={form.prodi_id} onChange={handleChange} required disabled={!form.jurusan}
                                    className={inputCls + (!form.jurusan ? ' text-gray-400 cursor-not-allowed' : '')}>
                                    <option value="" disabled hidden></option>
                                    {filteredProdis.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                                </select>
                            </FloatingField>
                        </div>

                        <div className="grid grid-cols-2 gap-3">
                            <FloatingField label="Keperluan" required value={form.purpose} isDropdown>
                                <select name="purpose" value={form.purpose} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    <option value="Kuliah">Kuliah</option>
                                    <option value="Praktikum">Praktikum</option>
                                </select>
                            </FloatingField>
                            <FloatingField label="Mata Kuliah" required value={form.mata_kuliah}>
                                <input type="text" name="mata_kuliah" value={form.mata_kuliah} onChange={handleChange} required
                                    className={inputCls} />
                            </FloatingField>
                        </div>

                        <div className="grid grid-cols-3 gap-3">
                            <FloatingField label="Semester" required value={form.semester} isDropdown>
                                <select name="semester" value={form.semester} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    {[1,2,3,4,5,6].map(s => <option key={s} value={s}>Semester {s}</option>)}
                                </select>
                            </FloatingField>
                            <FloatingField label="Kelas" required value={form.kelas} isDropdown>
                                <select name="kelas" value={form.kelas} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    {['A','B','C','D'].map(k => <option key={k} value={k}>Kelas {k}</option>)}
                                </select>
                            </FloatingField>
                            <FloatingField label="Dosen" required value={form.dosen}>
                                <input type="text" name="dosen" value={form.dosen} onChange={handleChange} required
                                    className={inputCls} />
                            </FloatingField>
                        </div>

                        <FloatingField label="Teknisi (Opsional)" value={form.teknisi}>
                            <input type="text" name="teknisi" value={form.teknisi} onChange={handleChange}
                                className={inputCls} />
                        </FloatingField>

                        <DatePickerField label="Tanggal Mulai" required value={form.date} name="date"
                            onChange={handleChange} min={new Date().toISOString().split('T')[0]} />

                        <input type="hidden" name="is_recurring" value="0" />
                        <input type="hidden" name="recurrence_end_date" value={recurrenceEndDate} />
                        <div className="bg-gray-50 rounded-xl p-4 border border-gray-100">
                            <label className="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_recurring" value="1" checked={form.is_recurring} onChange={handleChange}
                                    className="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500" />
                                <div>
                                    <span className="text-sm font-semibold text-gray-700">Booking Berulang</span>
                                    <p className="text-[11px] text-gray-400">Setiap minggu di hari yang sama</p>
                                </div>
                            </label>

                            {form.is_recurring && (
                                <div className="mt-4 space-y-3">
                                    <div className="flex items-center gap-2 text-sm">
                                        <ClockIcon />
                                        <span className="text-gray-600">Setiap</span>
                                        <span className="font-semibold text-gray-900">{recurrenceDay} ({form.date ? (() => { const [y, m, d] = form.date.split('-'); return `${d}/${m}/${y}`; })() : '-'})</span>
                                    </div>
                                    <div>
                                        <FloatingField label="Jumlah Perulangan" required value={form.recurrence_count} isDropdown>
                                            <select name="recurrence_count" value={form.recurrence_count} onChange={handleChange} required className={inputCls}>
                                                <option value="" disabled hidden></option>
                                                {Array.from({ length: 16 }, (_, i) => i + 1).map(n => (
                                                    <option key={n} value={n}>{n}x</option>
                                                ))}
                                            </select>
                                        </FloatingField>
                                        <p className="text-[11px] text-gray-400 mt-1">Maksimal 16x (16 minggu / 4 bulan)</p>
                                    </div>
                                    {showRecurrencePreview && (
                                        <div className="bg-indigo-50 rounded-lg p-3">
                                            <p className="text-xs font-semibold text-indigo-700 mb-1">Preview Jadwal:</p>
                                            <div className="text-[11px] text-indigo-600 space-y-0.5">
                                                {recurrenceDates.map((d, i) => (
                                                    <div key={i}>{i + 1}. {DAY_NAMES[d.getDay()]}, {d.toLocaleDateString('id-ID', { day: 'numeric', month: 'short', year: 'numeric' })}</div>
                                                ))}
                                            </div>
                                        </div>
                                    )}
                                </div>
                            )}
                        </div>

                        <div className="grid grid-cols-2 gap-3">
                            <FloatingField label="Jam Mulai" required value={form.start_time} isDropdown>
                                <select name="start_time" value={form.start_time} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    {TIME_SLOTS_START.map(t => <option key={t} value={t}>{t}</option>)}
                                </select>
                            </FloatingField>
                            <FloatingField label="Jam Selesai" required value={form.end_time} isDropdown>
                                <select name="end_time" value={form.end_time} onChange={handleChange} required className={inputCls}>
                                    <option value="" disabled hidden></option>
                                    {TIME_SLOTS_END.map(t => <option key={t} value={t}>{t}</option>)}
                                </select>
                            </FloatingField>
                        </div>

                        {showConflict && (
                            <div className="bg-red-50 border border-red-200 rounded-xl p-3">
                                <div className="flex items-center gap-2 mb-2">
                                    <WarningIcon />
                                    <p className="text-xs text-red-700 font-medium">Waktu ini bentrok dengan jadwal yang sudah ada!</p>
                                </div>
                                {conflicts.length > 0 && (
                                    <div className="space-y-1 ml-6">
                                        {conflicts.map((c, i) => (
                                            <p key={i} className="text-[11px] text-red-600">
                                                {c.start} - {c.end} ({c.status === 'approved' ? 'Disetujui' : 'Menunggu'})
                                            </p>
                                        ))}
                                    </div>
                                )}
                            </div>
                        )}

                        <FloatingField label="Catatan (Opsional)" value={form.notes}>
                            <textarea name="notes" value={form.notes} onChange={handleChange} rows="2"
                                className={inputCls + ' resize-none'} />
                        </FloatingField>

                        <button type="submit" disabled={showConflict}
                            className="w-full bg-indigo-600 text-white py-3 rounded-xl font-semibold hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed disabled:shadow-none flex items-center justify-center gap-2">
                            <RocketIcon />
                            Ajukan Booking
                        </button>
                        <p className="text-[11px] text-gray-400 text-center">Booking akan menunggu persetujuan admin</p>
                    </form>
                </div>
            </div>
        </div>
    );
}

function Field({ label, required, children }) {
    return (
        <div>
            <label className="block mb-2 text-sm font-semibold text-gray-900">
                {label} {required && <span className="text-red-500">*</span>}
            </label>
            {children}
        </div>
    );
}

function FloatingField({ label, required, children, value, isDropdown }) {
    const [focused, setFocused] = useState(false);
    const hasValue = value !== undefined && value !== null && value !== '';
    const isFloating = focused || hasValue;

    const enhancedChildren = React.Children.map(children, child => {
        if (!React.isValidElement(child)) return child;
        return React.cloneElement(child, {
            onFocus: (e) => {
                setFocused(true);
                child.props.onFocus?.(e);
            },
            onBlur: (e) => {
                setFocused(false);
                child.props.onBlur?.(e);
            },
        });
    });

    const labelStyle = {
        position: 'absolute',
        left: '0',
        top: isFloating ? '-0.75rem' : '50%',
        transform: isFloating ? 'translateY(0) scale(0.75)' : 'translateY(-50%) scale(1)',
        fontSize: '0.875rem',
        fontWeight: isFloating ? 600 : 400,
        color: isFloating ? '#2563eb' : '#6b7280',
        pointerEvents: 'none',
        transition: 'all 0.3s ease',
        transformOrigin: '0 0',
        zIndex: 10,
    };

    return (
        <div className="relative z-0 w-full group">
            {enhancedChildren}
            <label style={labelStyle}>
                {label}{required && <span style={{ color: '#ef4444', marginLeft: '2px' }}>*</span>}
            </label>
            {isDropdown && (
                <svg style={{ position: 'absolute', right: '0', top: '50%', transform: 'translateY(-50%)', width: '16px', height: '16px', color: '#6b7280', pointerEvents: 'none' }} fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            )}
        </div>
    );
}

const inputCls = 'block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 transition-colors';

function DatePickerField({ label, required, value, onChange, min, name }) {
    const [focused, setFocused] = useState(false);
    const [open, setOpen] = useState(false);
    const [calPos, setCalPos] = useState({ top: 0, left: 0 });
    const containerRef = useRef(null);
    const inputRef = useRef(null);
    const hasValue = value !== undefined && value !== null && value !== '';
    const isFloating = focused || hasValue;

    const today = new Date();
    const [viewDate, setViewDate] = useState(() => {
        if (value) {
            const [y, m, d] = value.split('-').map(Number);
            return new Date(y, m - 1, 1);
        }
        return new Date(today.getFullYear(), today.getMonth(), 1);
    });

    const minDate = min ? new Date(min + 'T00:00:00') : null;

    useEffect(() => {
        const handleClickOutside = (e) => {
            if (containerRef.current && !containerRef.current.contains(e.target)) {
                setOpen(false);
            }
        };
        document.addEventListener('mousedown', handleClickOutside);
        return () => document.removeEventListener('mousedown', handleClickOutside);
    }, []);

    useEffect(() => {
        if (!open) return;
        const recalc = () => {
            if (inputRef.current) {
                const rect = inputRef.current.getBoundingClientRect();
                setCalPos({ top: rect.bottom + 4, left: rect.left });
            }
        };
        const scrollEl = inputRef.current?.closest('.scrollbar-hide');
        if (scrollEl) {
            scrollEl.addEventListener('scroll', recalc, { passive: true });
            return () => scrollEl.removeEventListener('scroll', recalc);
        }
        window.addEventListener('scroll', recalc, { passive: true });
        window.addEventListener('resize', recalc, { passive: true });
        return () => {
            window.removeEventListener('scroll', recalc);
            window.removeEventListener('resize', recalc);
        };
    }, [open]);

    const positionCalendar = () => {
        if (inputRef.current) {
            const rect = inputRef.current.getBoundingClientRect();
            setCalPos({ top: rect.bottom + 4, left: rect.left });
        }
    };

    const formatDate = (dateStr) => {
        if (!dateStr) return '';
        const [y, m, d] = dateStr.split('-');
        return `${d}/${m}/${y}`;
    };

    const toStr = (y, m, d) => `${y}-${String(m + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

    const year = viewDate.getFullYear();
    const month = viewDate.getMonth();
    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();

    const prevMonth = () => setViewDate(new Date(year, month - 1, 1));
    const nextMonth = () => setViewDate(new Date(year, month + 1, 1));

    const selectDay = (day) => {
        const dateStr = toStr(year, month, day);
        if (minDate && new Date(dateStr + 'T00:00:00') < minDate) return;
        onChange({ target: { name, value: dateStr } });
        setOpen(false);
        setFocused(false);
    };

    const WEEKDAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    const days = [];
    for (let i = 0; i < firstDay; i++) days.push(null);
    for (let d = 1; d <= daysInMonth; d++) days.push(d);

    const handleOpen = () => {
        positionCalendar();
        setOpen(true);
    };

    return (
        <div className="relative z-0 w-full group" ref={containerRef}>
            <div className="absolute inset-y-0 start-0 flex items-center ps-0 pointer-events-none">
                <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v12a1 1 0 001 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                </svg>
            </div>
            <input type="text" ref={inputRef} value={formatDate(value)} readOnly
                className="block py-2.5 ps-9 pe-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none focus:outline-none focus:ring-0 focus:border-blue-600 transition-colors cursor-pointer"
                placeholder=" "
                onFocus={() => { setFocused(true); handleOpen(); }}
                onBlur={() => setFocused(false)}
                onClick={() => handleOpen()} />
            <input type="hidden" name={name} value={value || ''} />
            <label style={{
                position: 'absolute',
                left: isFloating || open ? '0' : '2.25rem',
                top: isFloating || open ? '-0.75rem' : '50%',
                transform: isFloating || open ? 'translateY(0) scale(0.75)' : 'translateY(-50%) scale(1)',
                fontSize: '0.875rem',
                fontWeight: isFloating || open ? 600 : 400,
                color: isFloating || open ? '#2563eb' : '#6b7280',
                pointerEvents: 'none',
                transition: 'all 0.3s ease',
                transformOrigin: '0 0',
                zIndex: 10,
            }}>
                {label}{required && <span style={{ color: '#ef4444', marginLeft: '2px' }}>*</span>}
            </label>
            {open && createPortal(
                <div className="bg-white rounded-xl shadow-2xl border border-gray-200 p-3"
                    style={{ position: 'fixed', top: calPos.top, left: calPos.left, zIndex: 9999, width: '280px' }}
                    onMouseDown={(e) => e.stopPropagation()}>
                    <div className="flex items-center justify-between mb-3">
                        <button type="button" onClick={prevMonth} className="p-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg className="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                        </button>
                        <span className="text-sm font-semibold text-gray-900">{MONTHS[month]} {year}</span>
                        <button type="button" onClick={nextMonth} className="p-1 rounded-lg hover:bg-gray-100 transition-colors">
                            <svg className="w-4 h-4 text-gray-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
                        </button>
                    </div>
                    <div className="grid grid-cols-7 mb-1">
                        {WEEKDAYS.map(d => (
                            <div key={d} className="text-center text-[11px] font-medium text-gray-400 py-1">{d}</div>
                        ))}
                    </div>
                    <div className="grid grid-cols-7">
                        {days.map((day, i) => {
                            if (day === null) return <div key={`e${i}`} />;
                            const dateStr = toStr(year, month, day);
                            const isToday = today.getFullYear() === year && today.getMonth() === month && today.getDate() === day;
                            const isSelected = value === dateStr;
                            const isDisabled = minDate && new Date(dateStr + 'T00:00:00') < minDate;
                            return (
                                <button key={day} type="button" disabled={isDisabled}
                                    onClick={() => selectDay(day)}
                                    className={`text-xs py-1.5 rounded-lg transition-colors
                                        ${isSelected ? 'bg-blue-600 text-white font-semibold' : isToday ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100'}
                                        ${isDisabled ? 'opacity-30 cursor-not-allowed' : 'cursor-pointer'}`}>
                                    {day}
                                </button>
                            );
                        })}
                    </div>
                    <div className="flex justify-center mt-2 pt-2 border-t border-gray-100">
                        <button type="button" onClick={() => { selectDay(today.getDate()); setViewDate(new Date(today.getFullYear(), today.getMonth(), 1)); }}
                            className="text-xs font-medium text-blue-600 hover:text-blue-800 transition-colors">
                            Hari Ini
                        </button>
                    </div>
                </div>,
                document.body
            )}
        </div>
    );
}

function CloseIcon() {
    return (
        <svg className="w-5 h-5 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    );
}

function ClockIcon() {
    return (
        <svg className="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    );
}

function WarningIcon() {
    return (
        <svg className="w-4 h-4 text-red-500 shrink-0" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
        </svg>
    );
}

function RocketIcon() {
    return (
        <svg className="w-5 h-5" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
        </svg>
    );
}
