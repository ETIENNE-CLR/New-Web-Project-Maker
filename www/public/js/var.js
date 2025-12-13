// HTTP
const isPublic = window.location.href.includes('https');
const httpText = `http${isPublic ? 's' : ''}://`;

// URLs
export const BASE_URL_API = httpText + 'new-web-project-maker' + '/api';
export const LS_JWT_KEY = 'jwt';
