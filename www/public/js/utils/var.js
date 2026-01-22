// HTTP
const IS_PUBLIC = window.location.href.includes('https');
const HTTP_TEXT = `http${IS_PUBLIC ? 's' : ''}://`;

// URL Keys
export const BASE_URL_WEB = HTTP_TEXT + 'new-web-project-maker';
export const BASE_URL_API = BASE_URL_WEB + '/api';
export const JWT_KEY = 'jwt';
