import { useState, useEffect } from 'react';
import WeekBar from './WeekBar';

const DAY_NAMES = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

function parseDateStr(s) {
    const [y, m, d] = s.split('-').map(Number);
    return new Date(y, m - 1, d);
}

export default function ScheduleGrid({ roomId, currentDate, initialBookings, onSelectDate }) {
    const [bookings, setBookings] = useState(initialBookings);
    const [loading, setLoading] = useState(false);
    const [selectedBooking, setSelectedBooking] = useState(null);

    useEffect(() => {
        setLoading(true);
        fetch(`/rooms/${roomId}/schedule?date=${currentDate}`)
            .then(r => r.json())
            .then(data => {
                setBookings(data.bookings || []);
                setLoading(false);
            })
            .catch(() => setLoading(false));
    }, [roomId, currentDate]);

    const d = parseDateStr(currentDate);
    const dayName = DAY_NAMES[d.getDay()];
    const formattedDate = d.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
    const isPast = d < new Date(new Date().setHours(0, 0, 0, 0));

    const slots = [];
    for (let h = 7; h <= 20; h++) {
        slots.push(String(h).padStart(2, '0') + ':00');
    }

    return (
        <div className="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
            <div className="p-6 border-b border-gray-100">
                <div className="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div>
                        <h2 className="text-lg font-bold text-gray-900">Jadwal Harian</h2>
                        <p className="text-sm text-gray-500 mt-0.5">{dayName}, {formattedDate}</p>
                    </div>
                    {onSelectDate && (
                        <div>
                            <WeekBar selectedDate={currentDate} onSelectDate={onSelectDate} />
                        </div>
                    )}
                </div>
            </div>
            <div className="p-6">
                {isPast ? (
                    <div className="text-center py-8">
                        <ClockIcon />
                        <p className="text-gray-500 text-sm">Tanggal ini sudah lewat. Pilih tanggal hari ini atau yang akan datang.</p>
                    </div>
                ) : loading ? (
                    <div className="text-center py-8">
                        <div className="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600" />
                        <p className="text-gray-500 text-sm mt-2">Memuat jadwal...</p>
                    </div>
                ) : (
                    <>
                        <div className="space-y-1">
                            {slots.map(slot => {
                                const hour = parseInt(slot);
                                const slotEnd = String(hour + 1).padStart(2, '0') + ':00';

                                const booking = bookings.find(b => {
                                    const bs = b.start_time.substring(0, 5);
                                    const be = b.end_time.substring(0, 5);
                                    return bs < slotEnd && be > slot;
                                });

                                const bs = booking ? booking.start_time.substring(0, 5) : null;
                                const isStart = booking && bs === slot;

                                if (booking && !isStart) return null;

                                if (booking && isStart) {
                                    const bookingStart = parseInt(bs);
                                    const bookingEnd = parseInt(booking.end_time.substring(0, 5));
                                    const spanHours = Math.max(1, bookingEnd - bookingStart);
                                    const isApproved = booking.status === 'approved';

                                    return (
                                        <div key={slot} className="flex items-stretch gap-3 min-h-[56px]" style={{ gridRow: `span ${spanHours}` }}>
                                            <div className="w-16 shrink-0 flex items-start pt-1.5">
                                                <span className="text-xs font-semibold text-gray-400">{slot}</span>
                                            </div>
                                            <button
                                                type="button"
                                                onClick={() => setSelectedBooking(booking)}
                                                className={`flex-1 rounded-xl px-4 py-3 border-l-4 text-left transition-all hover:shadow-md cursor-pointer ${isApproved ? 'bg-green-50 border-green-500 hover:bg-green-100' : 'bg-amber-50 border-amber-500 hover:bg-amber-100'}`}
                                                style={{ minHeight: `${spanHours * 56}px` }}
                                            >
                                                <div className="flex items-start justify-between">
                                                    <div>
                                                        <p className={`font-semibold text-sm ${isApproved ? 'text-green-800' : 'text-amber-800'}`}>
                                                            {booking.purpose}
                                                        </p>
                                                        <p className={`text-xs ${isApproved ? 'text-green-600' : 'text-amber-600'} mt-0.5`}>
                                                            {booking.booker_name} &middot; {bs} - {booking.end_time.substring(0, 5)}
                                                        </p>
                                                    </div>
                                                    <span className={`inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wide ${isApproved ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700'}`}>
                                                        {isApproved ? 'Disetujui' : 'Pending'}
                                                    </span>
                                                </div>
                                            </button>
                                        </div>
                                    );
                                }

                                return (
                                    <div key={slot} className="flex items-stretch gap-3">
                                        <div className="w-16 shrink-0 flex items-center pt-1.5">
                                            <span className="text-xs font-semibold text-gray-400">{slot}</span>
                                        </div>
                                        <div className="flex-1 h-14 rounded-xl border-2 border-dashed border-gray-100 hover:border-blue-200 hover:bg-blue-50/30 transition-all flex items-center justify-center px-4">
                                            <span className="text-sm text-green-600 font-semibold flex items-center gap-1.5">
                                                <span className="w-2 h-2 bg-green-400 rounded-full" />
                                                Tersedia
                                            </span>
                                        </div>
                                    </div>
                                );
                            })}
                        </div>

                        <div className="flex items-center gap-6 mt-6 pt-4 border-t border-gray-100">
                            <div className="flex items-center gap-2">
                                <div className="w-4 h-4 rounded border-2 border-dashed border-gray-200" />
                                <span className="text-xs text-gray-500">Tersedia</span>
                            </div>
                            <div className="flex items-center gap-2">
                                <div className="w-4 h-4 rounded bg-green-50 border-l-2 border-green-500" />
                                <span className="text-xs text-gray-500">Disetujui</span>
                            </div>
                            <div className="flex items-center gap-2">
                                <div className="w-4 h-4 rounded bg-amber-50 border-l-2 border-amber-500" />
                                <span className="text-xs text-gray-500">Menunggu</span>
                            </div>
                        </div>
                    </>
                )}
            </div>

            {selectedBooking && (
                <BookingDetailModal booking={selectedBooking} onClose={() => setSelectedBooking(null)} />
            )}
        </div>
    );
}

function BookingDetailModal({ booking, onClose }) {
    const isApproved = booking.status === 'approved';

    return (
        <div className="fixed inset-0 z-50" role="dialog" aria-modal="true">
            <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={onClose} />
            <div className="absolute inset-0 flex items-center justify-center p-4">
                <div className="bg-white rounded-2xl shadow-2xl w-full max-w-lg overflow-hidden">
                    <div className={`px-6 py-4 ${isApproved ? 'bg-gradient-to-r from-green-500 to-emerald-500' : 'bg-gradient-to-r from-amber-500 to-orange-500'}`}>
                        <div className="flex items-center justify-between">
                            <div className="flex items-center gap-3">
                                <div className="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center">
                                    <svg className="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 className="text-lg font-bold text-white">{booking.booker_name}</h3>
                                    <p className="text-sm text-white/80">{booking.purpose} &middot; {booking.start_time.substring(0, 5)} - {booking.end_time.substring(0, 5)}</p>
                                </div>
                            </div>
                            <button type="button" onClick={onClose} className="p-2 rounded-lg hover:bg-white/20 transition-colors">
                                <svg className="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div className="p-6">
                        <div className="grid grid-cols-2 gap-3">
                            <InfoCard icon={<ClockIcon2 />} label="Waktu" value={`${booking.start_time.substring(0, 5)} - ${booking.end_time.substring(0, 5)}`} color="blue" />
                            <InfoCard icon={<BookIcon />} label="Keperluan" value={booking.purpose} color="blue" />
                            <InfoCard icon={<AcademicIcon />} label="Jurusan" value={booking.jurusan} color="blue" />
                            <InfoCard icon={<BuildingIcon />} label="Prodi" value={booking.prodi} color="pink" />
                            <InfoCard icon={<BookOpenIcon />} label="Mata Kuliah" value={booking.mata_kuliah} color="teal" />
                            <InfoCard icon={<CalendarIcon />} label="Semester" value={`Semester ${booking.semester}`} color="orange" />
                            <InfoCard icon={<ClassIcon />} label="Kelas" value={`Kelas ${booking.kelas}`} color="cyan" />
                            <InfoCard icon={<UserIcon />} label="Dosen" value={booking.dosen} color="rose" />
                            {booking.teknisi && <InfoCard icon={<WrenchIcon />} label="Teknisi" value={booking.teknisi} color="slate" />}
                        </div>

                        <div className="mt-4 pt-4 border-t border-gray-100">
                            <p className="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Kontak</p>
                            <div className="grid grid-cols-2 gap-3">
                                <InfoCard icon={<PhoneIcon />} label="No. WhatsApp" value={booking.booker_phone} color="green" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

const CARD_COLORS = {
    blue: 'bg-blue-50 text-blue-600',
    pink: 'bg-pink-50 text-pink-600',
    teal: 'bg-teal-50 text-teal-600',
    orange: 'bg-orange-50 text-orange-600',
    cyan: 'bg-cyan-50 text-cyan-600',
    rose: 'bg-rose-50 text-rose-600',
    green: 'bg-green-50 text-green-600',
    slate: 'bg-slate-100 text-slate-600',
};

function InfoCard({ icon, label, value, color = 'gray' }) {
    const colorCls = CARD_COLORS[color] || 'bg-gray-50 text-gray-600';
    return (
        <div className="bg-gray-50 rounded-xl p-3">
            <div className="flex items-center gap-2 mb-1.5">
                <div className={`w-6 h-6 rounded-md flex items-center justify-center ${colorCls}`}>
                    {icon}
                </div>
                <p className="text-[11px] text-gray-500 font-medium">{label}</p>
            </div>
            <p className="text-sm font-semibold text-gray-900 pl-8">{value}</p>
        </div>
    );
}

function ClockIcon() {
    return (
        <svg className="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" strokeWidth="1.5" stroke="currentColor">
            <path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    );
}

function ClockIcon2() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>;
}
function BookIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>;
}
function AcademicIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342" /></svg>;
}
function BuildingIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" /></svg>;
}
function BookOpenIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25m0 0a8.966 8.966 0 01-6 2.292c-1.052 0-2.062.18-3 .512V21m8.25-14.25v14.25m0 0a8.966 8.966 0 006 2.292c1.052 0 2.062-.18 3-.512V21" /></svg>;
}
function CalendarIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>;
}
function ClassIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" /></svg>;
}
function UserIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>;
}
function WrenchIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M11.42 15.17l-5.1-5.1m0 0L11.42 4.97m-5.1 5.1H21M3 3h7.5M3 21h7.5" /></svg>;
}
function PhoneIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" /></svg>;
}
function EmailIcon() {
    return <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor"><path strokeLinecap="round" strokeLinejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75" /></svg>;
}
