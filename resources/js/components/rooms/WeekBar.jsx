const SHORT_DAY_NAMES = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

function formatDateStr(d) {
    return d.getFullYear() + '-' + String(d.getMonth() + 1).padStart(2, '0') + '-' + String(d.getDate()).padStart(2, '0');
}

function parseDateStr(s) {
    const [y, m, d] = s.split('-').map(Number);
    return new Date(y, m - 1, d);
}

function getWeekStart(dateStr) {
    const d = parseDateStr(dateStr);
    const day = d.getDay();
    const diff = (day + 6) % 7;
    const monday = new Date(d);
    monday.setDate(d.getDate() - diff);
    return monday;
}

export default function WeekBar({ selectedDate, onSelectDate }) {
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const weekStart = getWeekStart(selectedDate);

    const days = [];
    for (let i = 0; i < 7; i++) {
        const d = new Date(weekStart);
        d.setDate(weekStart.getDate() + i);
        const dateStr = formatDateStr(d);
        const dayName = SHORT_DAY_NAMES[d.getDay()];
        const dayNum = d.getDate();
        const isActive = dateStr === selectedDate;
        const isPast = d < today;
        const isTodayDate = d.getTime() === today.getTime();

        let cls = 'flex flex-col items-center justify-center px-2 sm:px-3 py-2.5 rounded-lg text-center transition-all min-w-0 ';
        if (isActive) {
            cls += 'bg-blue-600 text-white shadow-md ';
        } else if (isPast) {
            cls += 'text-gray-300 cursor-not-allowed ';
        } else {
            cls += 'text-gray-600 hover:bg-gray-100 ';
        }

        days.push(
            <button
                key={dateStr}
                type="button"
                disabled={isPast}
                className={cls}
                onClick={() => onSelectDate(dateStr)}
            >
                <span className="text-[10px] font-bold uppercase">{dayName}</span>
                <span className="text-base font-bold leading-tight mt-0.5">{dayNum}</span>
                {isTodayDate && !isActive && <span className="w-1 h-1 rounded-full bg-blue-500 mt-0.5" />}
                {isTodayDate && isActive && <span className="w-1 h-1 rounded-full bg-white mt-0.5" />}
            </button>
        );
    }

    const prevWeek = () => {
        const d = new Date(weekStart);
        d.setDate(d.getDate() - 7);
        if (d < today) return;
        onSelectDate(formatDateStr(d));
    };

    const nextWeek = () => {
        const d = new Date(weekStart);
        d.setDate(d.getDate() + 7);
        onSelectDate(formatDateStr(d));
    };

    return (
        <div className="flex items-center gap-1">
            <button type="button" onClick={prevWeek} className="p-1.5 rounded-lg hover:bg-gray-100 transition-colors shrink-0">
                <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </button>
            <div className="flex items-center gap-0.5 bg-gray-50 rounded-xl p-0.5 flex-1">
                {days}
            </div>
            <button type="button" onClick={nextWeek} className="p-1.5 rounded-lg hover:bg-gray-100 transition-colors shrink-0">
                <svg className="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" strokeWidth="2" stroke="currentColor">
                    <path strokeLinecap="round" strokeLinejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </button>
        </div>
    );
}
