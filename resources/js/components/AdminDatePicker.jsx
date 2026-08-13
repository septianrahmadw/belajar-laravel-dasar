import React, { useState, useEffect, useRef } from 'react';
import { createPortal } from 'react-dom';

export default function AdminDatePicker({ name, initialValue }) {
    const [open, setOpen] = useState(false);
    const [value, setValue] = useState(initialValue || '');
    const [calPos, setCalPos] = useState({ top: 0, left: 0 });
    const containerRef = useRef(null);
    const inputRef = useRef(null);

    const today = new Date();
    const [viewDate, setViewDate] = useState(() => {
        if (initialValue) {
            const [y, m, d] = initialValue.split('-').map(Number);
            return new Date(y, m - 1, 1);
        }
        return new Date(today.getFullYear(), today.getMonth(), 1);
    });

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
        
        setTimeout(recalc, 0);
        
        window.addEventListener('scroll', recalc, { passive: true });
        window.addEventListener('resize', recalc, { passive: true });
        return () => {
            window.removeEventListener('scroll', recalc);
            window.removeEventListener('resize', recalc);
        };
    }, [open]);

    const handleOpen = () => setOpen(true);

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
        setValue(dateStr);
        setOpen(false);
    };

    const WEEKDAYS = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
    const MONTHS = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    const days = [];
    for (let i = 0; i < firstDay; i++) days.push(null);
    for (let d = 1; d <= daysInMonth; d++) days.push(d);

    return (
        <div className="relative z-0" ref={containerRef}>
            <div className="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M4 10h16m-8-3V4M7 7V4m10 3V4M5 20h14a1 1 0 001-1V7a1 1 0 00-1-1H5a1 1 0 00-1 1v12a1 1 0 001 1Zm3-7h.01v.01H8V13Zm4 0h.01v.01H12V13Zm4 0h.01v.01H16V13Zm-8 4h.01v.01H8V17Zm4 0h.01v.01H12V17Zm4 0h.01v.01H16V17Z" />
                </svg>
            </div>
            <input type="text" ref={inputRef} value={formatDate(value)} readOnly
                className="block w-36 py-2 ps-9 pe-3 text-sm text-gray-900 bg-white border border-gray-200 rounded-lg appearance-none focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors cursor-pointer"
                placeholder="Pilih Tanggal"
                onClick={handleOpen} />
            <input type="hidden" name={name} value={value || ''} />
            
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
                            return (
                                <button key={day} type="button"
                                    onClick={() => selectDay(day)}
                                    className={`text-xs py-1.5 rounded-lg transition-colors cursor-pointer
                                        ${isSelected ? 'bg-blue-600 text-white font-semibold' : isToday ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700 hover:bg-gray-100'}`}>
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
