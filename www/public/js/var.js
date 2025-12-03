// HTTP
const isPublic = window.location.href.includes('https');
const httpText = `http${isPublic ? 's' : ''}://`;

// URLs
export const BASE_URL_API = httpText + (isPublic ? 'xx.x.xx.xx' : 'new-web-project-maker');
export const BASE_URL_DEBUG = `${BASE_URL_API}/debug-web`;
export const LS_JWT_KEY = 'jwt';
