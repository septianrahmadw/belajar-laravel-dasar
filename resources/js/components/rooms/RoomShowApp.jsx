import { useState, useCallback } from 'react';
import CalendarWidget from './CalendarWidget';
import ScheduleGrid from './ScheduleGrid';
import BookingModal from './BookingModal';

export default function RoomShowApp({ room, currentDate, monthBookings, prodis, initialBookings }) {
    const [selectedDate, setSelectedDate] = useState(currentDate);
    const [showModal, setShowModal] = useState(false);

    const handleSelectDate = useCallback((dateStr) => {
        setSelectedDate(dateStr);
        const params = new URLSearchParams(window.location.search);
        params.set('date', dateStr);
        const newUrl = window.location.pathname + '?' + params.toString();
        history.replaceState({}, '', newUrl);
    }, []);

    return (
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div className="mb-6">
                <a href="/rooms" className="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 transition-colors">
                    <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                        <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                    </svg>
                    Kembali ke Daftar Ruangan
                </a>
            </div>

            <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div className="lg:col-span-2 lg:col-start-1 lg:row-start-1">
                    <RoomHeader room={room} />
                </div>

                <div className="lg:col-span-1 lg:col-start-3 lg:row-start-1 lg:row-span-2 lg:self-start">
                    <CalendarWidget
                        actionButton={
                            <button
                                onClick={() => setShowModal(true)}
                                className="w-full inline-flex items-center justify-center gap-1.5 px-4 py-2.5 bg-indigo-600 text-white text-sm font-semibold rounded-xl hover:bg-indigo-700 transition-all shadow-lg shadow-indigo-200"
                            >
                                <svg className="w-4 h-4" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Ajukan Peminjaman
                            </button>
                        }
                        roomId={room.id}
                        initialDate={currentDate}
                        selectedDate={selectedDate}
                        initialMonthBookings={monthBookings}
                        onSelectDate={handleSelectDate}
                    />
                </div>

                <div className="lg:col-span-2 lg:col-start-1 lg:row-start-2">
                    <ScheduleGrid
                        roomId={room.id}
                        currentDate={selectedDate}
                        initialBookings={initialBookings}
                        onSelectDate={handleSelectDate}
                    />
                </div>
            </div>

            <BookingModal
                isOpen={showModal}
                onClose={() => setShowModal(false)}
                roomId={room.id}
                currentDate={selectedDate}
                prodis={prodis}
            />
        </div>
    );
}

function RoomHeader({ room }) {
    return (
        <div className="bg-white/50 backdrop-blur-xl rounded-2xl border border-white/40 shadow-lg overflow-hidden">
            <div className="h-24 bg-gradient-to-br from-blue-500 via-blue-600 to-indigo-600 rounded-t-2xl relative">
                <div className="absolute inset-0 flex items-center justify-center">
                    <h1 className="text-4xl font-bold text-white drop-shadow-lg">{room.name}</h1>
                </div>
            </div>
            <div className="p-6 bg-white/20 backdrop-blur-sm">
                <div className="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg className="w-5 h-5 text-indigo-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path strokeLinecap="round" strokeLinejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                            </svg>
                        </div>
                        <div>
                            <p className="text-xs text-gray-500">Lokasi</p>
                            <p className="text-sm font-semibold text-gray-900">{room.location}</p>
                        </div>
                    </div>
                    <div className="flex items-center gap-3">
                        <div className="w-10 h-10 bg-white/30 backdrop-blur-sm rounded-lg flex items-center justify-center">
                            <svg className="w-5 h-5 text-green-600" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                <path strokeLinecap="round" strokeLinejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                        </div>
                        <div>
                            <p className="text-xs text-gray-500">Kapasitas</p>
                            <p className="text-sm font-semibold text-gray-900">{room.capacity} orang</p>
                        </div>
                    </div>
                </div>
                {room.description && (
                    <p className="text-gray-600 text-sm leading-relaxed mb-6">{room.description}</p>
                )}
                {room.facilities && room.facilities.length > 0 && (
                    <div>
                        <h4 className="text-sm font-semibold text-gray-900 mb-2">Fasilitas</h4>
                        <div className="flex flex-wrap gap-2">
                            {room.facilities.map((facility, i) => (
                                <span key={i} className="inline-flex items-center gap-1 px-3 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700">
                                    <svg className="w-3 h-3" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                                        <path strokeLinecap="round" strokeLinejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                                    </svg>
                                    {facility}
                                </span>
                            ))}
                        </div>
                    </div>
                )}
            </div>
        </div>
    );
}
