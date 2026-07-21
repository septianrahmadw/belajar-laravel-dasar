import { useState, useCallback, useEffect } from 'react';

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

export default function BookingModal({ isOpen, onClose, roomId, currentDate, prodis, monthBookings }) {
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
        recurrence_end_date: '',
        notes: '',
    });

    const [filteredProdis, setFilteredProdis] = useState(prodis);
    const [showConflict, setShowConflict] = useState(false);
    const [conflicts, setConflicts] = useState([]);
    const [recurrenceDates, setRecurrenceDates] = useState([]);
    const [showRecurrencePreview, setShowRecurrencePreview] = useState(false);

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
        if (form.is_recurring && form.date && form.recurrence_end_date) {
            const start = new Date(form.date + 'T00:00:00');
            const end = new Date(form.recurrence_end_date + 'T00:00:00');
            const dates = [];
            let current = new Date(start);
            while (current <= end && dates.length < 12) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 7);
            }
            setRecurrenceDates(dates);
            setShowRecurrencePreview(dates.length > 0);
        } else {
            setRecurrenceDates([]);
            setShowRecurrencePreview(false);
        }
    }, [form.is_recurring, form.date, form.recurrence_end_date]);

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

    if (!isOpen) return null;

    return (
        <div className="fixed inset-0 z-50" aria-modal="true" role="dialog">
            <div className="absolute inset-0 bg-black/50 backdrop-blur-sm" onClick={onClose} />
            <div className="absolute inset-0 flex items-center justify-center p-4">
                <div className="bg-white rounded-2xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                    <div className="sticky top-0 z-10 bg-white rounded-t-2xl border-b border-gray-100">
                        <div className="flex items-center justify-between p-5">
                            <div>
                                <h2 className="text-lg font-bold text-gray-900">Form Peminjaman</h2>
                                <p className="text-sm text-gray-500 mt-0.5">Isi data diri untuk melakukan booking</p>
                            </div>
                            <button type="button" onClick={onClose} className="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                <CloseIcon />
                            </button>
                        </div>
                    </div>

                    <form action="/bookings" method="POST" onSubmit={handleSubmit} className="p-5 pt-2 space-y-4">
                        <input type="hidden" name="_token" value={document.querySelector('meta[name="csrf-token"]')?.content || ''} />
                        <input type="hidden" name="room_id" value={roomId} />

                        <div className="grid grid-cols-2 gap-3">
                            <Field label="Nama Lengkap" required>
                                <input type="text" name="booker_name" value={form.booker_name} onChange={handleChange} required
                                    className={inputCls} placeholder="Nama lengkap" />
                            </Field>
                            <Field label="Email" required>
                                <input type="email" name="booker_email" value={form.booker_email} onChange={handleChange} required
                                    className={inputCls} placeholder="email@..." />
                            </Field>
                        </div>

                        <Field label="No. WhatsApp" required>
                            <input type="tel" name="booker_phone" value={form.booker_phone} onChange={handleChange} required
                                className={inputCls} placeholder="08xxxxxxxxxx" />
                        </Field>

                        <div className="grid grid-cols-2 gap-3">
                            <Field label="Jurusan" required>
                                <select name="jurusan" value={form.jurusan} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih</option>
                                    {JURUSAN_OPTIONS.map(j => <option key={j} value={j}>{j}</option>)}
                                </select>
                            </Field>
                            <Field label="Prodi" required>
                                <select name="prodi_id" value={form.prodi_id} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih</option>
                                    {filteredProdis.map(p => <option key={p.id} value={p.id}>{p.name}</option>)}
                                </select>
                            </Field>
                        </div>

                        <div className="grid grid-cols-2 gap-3">
                            <Field label="Keperluan" required>
                                <select name="purpose" value={form.purpose} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih</option>
                                    <option value="Kuliah">Kuliah</option>
                                    <option value="Praktikum">Praktikum</option>
                                </select>
                            </Field>
                            <Field label="Mata Kuliah" required>
                                <input type="text" name="mata_kuliah" value={form.mata_kuliah} onChange={handleChange} required
                                    className={inputCls} placeholder="Nama MK" />
                            </Field>
                        </div>

                        <div className="grid grid-cols-3 gap-3">
                            <Field label="Semester" required>
                                <select name="semester" value={form.semester} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih</option>
                                    {[1,2,3,4,5,6].map(s => <option key={s} value={s}>Semester {s}</option>)}
                                </select>
                            </Field>
                            <Field label="Kelas" required>
                                <select name="kelas" value={form.kelas} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih</option>
                                    {['A','B','C','D'].map(k => <option key={k} value={k}>Kelas {k}</option>)}
                                </select>
                            </Field>
                            <Field label="Dosen" required>
                                <input type="text" name="dosen" value={form.dosen} onChange={handleChange} required
                                    className={inputCls} placeholder="Nama dosen" />
                            </Field>
                        </div>

                        <Field label="Teknisi (Opsional)">
                            <input type="text" name="teknisi" value={form.teknisi} onChange={handleChange}
                                className={inputCls} placeholder="Nama teknisi" />
                        </Field>

                        <Field label="Tanggal Mulai" required>
                            <input type="date" name="date" value={form.date} onChange={handleChange} required
                                min={new Date().toISOString().split('T')[0]} className={inputCls} />
                        </Field>

                        <input type="hidden" name="is_recurring" value="0" />
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
                                        <span className="font-semibold text-gray-900">{recurrenceDay} ({form.date})</span>
                                    </div>
                                    <div>
                                        <label className="block text-xs font-semibold text-gray-600 mb-1.5">Berakhir pada</label>
                                        <input type="date" name="recurrence_end_date" value={form.recurrence_end_date} onChange={handleChange}
                                            min={new Date().toISOString().split('T')[0]} className={inputCls} />
                                        <p className="text-[11px] text-gray-400 mt-1">Maksimal 12 minggu (3 bulan)</p>
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
                            <Field label="Jam Mulai" required>
                                <select name="start_time" value={form.start_time} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih jam</option>
                                    {TIME_SLOTS_START.map(t => <option key={t} value={t}>{t}</option>)}
                                </select>
                            </Field>
                            <Field label="Jam Selesai" required>
                                <select name="end_time" value={form.end_time} onChange={handleChange} required className={inputCls}>
                                    <option value="">Pilih jam</option>
                                    {TIME_SLOTS_END.map(t => <option key={t} value={t}>{t}</option>)}
                                </select>
                            </Field>
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

                        <Field label="Catatan (Opsional)">
                            <textarea name="notes" value={form.notes} onChange={handleChange} rows="2"
                                className={inputCls + ' resize-none'} placeholder="Tulis catatan jika diperlukan..." />
                        </Field>

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

const inputCls = 'block w-full px-3 py-2.5 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-indigo-500 focus:border-indigo-500 shadow-sm placeholder:text-gray-400';

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
