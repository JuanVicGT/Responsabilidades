import './bootstrap';

import { Calendar } from '@fullcalendar/core';
window.Calendar = Calendar;

import dayGridPlugin from '@fullcalendar/daygrid';
window.dayGridPlugin = dayGridPlugin;

import timeGridPlugin from '@fullcalendar/timegrid';
window.timeGridPlugin = timeGridPlugin;

import listPlugin from '@fullcalendar/list';
window.listPlugin = listPlugin;

import esLocale from '@fullcalendar/core/locales/es';
window.esLocale = esLocale;