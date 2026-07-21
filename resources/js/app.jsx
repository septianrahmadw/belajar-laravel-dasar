import '../css/app.css';
import { createRoot } from 'react-dom/client';
import RoomShowApp from './components/rooms/RoomShowApp';

const mountPoint = document.getElementById('room-show-app');
if (mountPoint) {
    const props = JSON.parse(mountPoint.dataset.props || '{}');
    const root = createRoot(mountPoint);
    root.render(<RoomShowApp {...props} />);
}
