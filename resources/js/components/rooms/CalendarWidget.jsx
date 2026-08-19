import { useState, useCallback, useEffect, useRef } from 'react';

const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
const DAY_HEADERS = ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'];

function formatDateStr(d) {
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}

function parseDateStr(s) {
    const [y, m, d] = s.split('-').map(Number);
    return new Date(y, m - 1, d);
}

export default function CalendarWidget({ roomId, initialDate, selectedDate: externalSelectedDate, initialMonthBookings, onSelectDate, actionButton }) {
    const [calendarDate, setCalendarDate] = useState(() => parseDateStr(initialDate));
    const [selectedDate, setSelectedDate] = useState(initialDate);
    const [monthBookings, setMonthBookings] = useState(initialMonthBookings || {});
    const monthCache = useRef(initialDate ? { [initialDate.substring(0, 7)]: initialMonthBookings || {} } : {});

    const year = calendarDate.getFullYear();
    const month = calendarDate.getMonth();
    const monthStr = year + '-' + String(month + 1).padStart(2, '0');

    useEffect(() => {
        let cancelled = false;
        if (monthCache.current[monthStr]) {
            setMonthBookings(monthCache.current[monthStr]);
            return undefined;
        }
        fetch(`/rooms/${roomId}/month?month=${monthStr}`)
            .then(r => r.json())
            .then(data => {
                if (cancelled) return;
                const bookings = data.bookings || {};
                monthCache.current[monthStr] = bookings;
                setMonthBookings(bookings);
            })
            .catch(() => {});
        return () => { cancelled = true; };
    }, [roomId, monthStr]);

    useEffect(() => {
        if (externalSelectedDate && externalSelectedDate !== selectedDate) {
            setSelectedDate(externalSelectedDate);
            const extDate = parseDateStr(externalSelectedDate);
            const calMonth = calendarDate.getMonth();
            const calYear = calendarDate.getFullYear();
            if (extDate.getMonth() !== calMonth || extDate.getFullYear() !== calYear) {
                setCalendarDate(extDate);
            }
        }
    }, [externalSelectedDate]);

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const navigateMonth = useCallback((delta) => {
        setCalendarDate(prev => {
            const next = new Date(prev);
            next.setMonth(next.getMonth() + delta);
            return next;
        });
    }, []);

    const handleSelectDate = useCallback((dateStr) => {
        const d = parseDateStr(dateStr);
        if (d < today) return;
        setSelectedDate(dateStr);
        onSelectDate(dateStr);
    }, [onSelectDate, today]);

    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDay = firstDay.getDay();
    const startOffset = startDay === 0 ? 6 : startDay - 1;

    const monthLabel = calendarDate.toLocaleDateString('id-ID', { month: 'long' });

    const cells = [];
    for (let i = 0; i < startOffset; i++) {
        cells.push(<div key={'empty-' + i} />);
    }
    for (let d = 1; d <= lastDay.getDate(); d++) {
        const cellDate = new Date(year, month, d);
        cellDate.setHours(0, 0, 0, 0);
        const dateStr = formatDateStr(cellDate);

        const isPast = cellDate < today;
        const isSelected = dateStr === selectedDate;
        const dayBookings = monthBookings[dateStr] || [];

        let btnCls = 'w-full h-full flex flex-col items-center justify-center gap-0.5 rounded-lg text-sm font-bold transition-all ';
        if (isPast) {
            btnCls += 'text-gray-300 cursor-not-allowed ';
        } else if (isSelected) {
            btnCls += 'bg-blue-600 text-white shadow-md ';
        } else {
            btnCls += 'text-gray-700 hover:bg-gray-100 ';
        }

        let badgeCls = '';
        let approvedBadgeCls = '';
        let pendingBadgeCls = '';
        if (dayBookings.length > 0) {
            const approvedCount = dayBookings.filter(b => b.status === 'approved').length;
            const pendingCount = dayBookings.filter(b => b.status === 'pending').length;
            if (!isSelected) {
                if (approvedCount > 0 && pendingCount === 0) {
                    btnCls += 'bg-green-100 text-green-800 font-bold ';
                } else if (pendingCount > 0 && approvedCount === 0) {
                    btnCls += 'bg-amber-100 text-amber-800 font-bold ';
                } else {
                    btnCls += 'bg-gradient-to-br from-green-100 to-amber-100 text-gray-800 font-bold ';
                }
            }
            approvedBadgeCls = 'bg-green-500 text-white';
            pendingBadgeCls = 'bg-amber-400 text-white';
        }

        cells.push(
            <div key={dateStr} className="aspect-square p-0.5">
                <button
                    type="button"
                    disabled={isPast}
                    className={btnCls}
                    onClick={() => handleSelectDate(dateStr)}
                >
                    <span className="leading-none">{d}</span>
                    {dayBookings.length > 0 && (
                        <span className="flex items-center justify-center gap-0.5">
                            {dayBookings.filter(b => b.status === 'approved').length > 0 && (
                                <span className={`min-w-[14px] h-3.5 flex items-center justify-center rounded text-[8px] font-bold leading-none px-0.5 ${approvedBadgeCls}`}>
                                    {dayBookings.filter(b => b.status === 'approved').length}
                                </span>
                            )}
                            {dayBookings.filter(b => b.status === 'pending').length > 0 && (
                                <span className={`min-w-[14px] h-3.5 flex items-center justify-center rounded text-[8px] font-bold leading-none px-0.5 ${pendingBadgeCls}`}>
                                    {dayBookings.filter(b => b.status === 'pending').length}
                                </span>
                            )}
                        </span>
                    )}
                </button>
            </div>
        );
    }

    const selectedBookings = monthBookings[selectedDate] || [];
    const selectedDateObj = parseDateStr(selectedDate);
    const dayName = DAY_NAMES[selectedDateObj.getDay()];
    const formattedDate = selectedDateObj.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });

    return (
        <div className="bg-white/60 backdrop-blur-lg rounded-2xl border border-white/40 shadow-lg overflow-hidden">
            <div className="p-4 border-b border-white/30 bg-white/20 backdrop-blur-xl">
                <h2 className="text-xl font-extrabold text-gray-900 text-center">Kalender</h2>
                <p className="text-sm text-gray-600 mt-0.5 text-center">Lihat jadwal sebulan penuh</p>
                {actionButton && (
                    <div className="mt-3">
                        {actionButton}
                    </div>
                )}
            </div>

            <div className="p-4">
                <div className="flex items-center justify-between mb-4">
                    <button type="button" onClick={() => navigateMonth(-1)} className="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <ChevronLeft />
                    </button>
                    <div className="text-center">
                        <h3 className="text-base font-bold text-gray-900">{monthLabel}</h3>
                        <p className="text-xs text-gray-500 font-medium">{dayName}, {formattedDate}</p>
                    </div>
                    <button type="button" onClick={() => navigateMonth(1)} className="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <ChevronRight />
                    </button>
                </div>

                <div className="grid grid-cols-7 gap-0.5 text-center mb-2">
                    {DAY_HEADERS.map(dh => (
                        <div key={dh} className="text-[11px] font-semibold text-gray-400 py-1.5">{dh}</div>
                    ))}
                </div>

                <div className="grid grid-cols-7 gap-0.5">
                    {cells}
                </div>

                <div className="flex items-center justify-center gap-4 mt-3 pt-3 border-t border-gray-100">
                    <span className="inline-flex items-center gap-1.5 text-[11px] text-gray-500">
                        <span className="w-2.5 h-2.5 rounded-full bg-green-500" /> Disetujui
                    </span>
                    <span className="inline-flex items-center gap-1.5 text-[11px] text-gray-500">
                        <span className="w-2.5 h-2.5 rounded-full bg-amber-400" /> Menunggu
                    </span>
                </div>

                <div className="mt-4 pt-3 border-t border-gray-100">
                    {selectedBookings.length > 0 && (
                        <div className="space-y-1">
                            {selectedBookings.map((b, i) => {
                                const isApproved = b.status === 'approved';
                                return (
                                    <div key={i} className={`flex items-center justify-between text-xs px-2 py-1 rounded-lg ${isApproved ? 'bg-green-50' : 'bg-amber-50'}`}>
                                        <span className="text-gray-700">{b.start}-{b.end} &middot; {b.purpose}</span>
                                        <span className={`font-semibold ${isApproved ? 'text-green-700' : 'text-amber-700'}`}>
                                            {isApproved ? 'Disetujui' : 'Pending'}
                                        </span>
                                    </div>
                                );
                            })}
                        </div>
                    )}
                </div>
            </div>
        </div>
    );
}

function ChevronLeft() {
    return (
        <svg className="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
        </svg>
    );
}

function ChevronRight() {
    return (
        <svg className="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
        </svg>
    );
}
