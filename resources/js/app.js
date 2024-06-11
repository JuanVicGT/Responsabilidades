import './bootstrap';

import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import esLocale from '@fullcalendar/core/locales/es';

window.Calendar = Calendar;
window.dayGridPlugin = dayGridPlugin;
window.esLocale = esLocale;