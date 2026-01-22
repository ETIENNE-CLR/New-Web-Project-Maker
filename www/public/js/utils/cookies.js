/**
 * Fonction qui permet de récupérer un cookie
 * @param {string} name Nom du cookie à récupérer
 * @returns {*|null} Valeur du cookie récupérer. `null` s'il n'existe pas 
 */
export function getCookie(name) {
    const value = document.cookie.split('; ').find(row => row.startsWith(name + '='));
    return value ? value.split('=')[1] : null;
}

/**
 * Fonction qui permet de définir un cookie
 * @param {string} name Nom du cookie 
 * @param {*} value Valeur du cookie
 * @param {number} days Nbr de validité du cookie en jours
 */
export function setCookie(name, value, days = 365) {
    const expires = new Date(Date.now() + days * 864e5).toUTCString();
    document.cookie = `${name}=${value}; expires=${expires}; path=/`;
}