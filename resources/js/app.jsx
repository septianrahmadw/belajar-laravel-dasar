import '../css/app.css';
import { createRoot } from 'react-dom/client';
import RoomShowApp from './components/rooms/RoomShowApp';

const mountPoint = document.getElementById('room-show-app');
if (mountPoint) {
    const props = JSON.parse(mountPoint.dataset.props || '{}');
    const root = createRoot(mountPoint);
    root.render(<RoomShowApp {...props} />);
}

import AdminDatePicker from './components/AdminDatePicker';
const adminDatePickers = document.querySelectorAll('.admin-datepicker-root');
adminDatePickers.forEach(el => {
    const props = JSON.parse(el.dataset.props || '{}');
    const root = createRoot(el);
    root.render(<AdminDatePicker {...props} />);
});
