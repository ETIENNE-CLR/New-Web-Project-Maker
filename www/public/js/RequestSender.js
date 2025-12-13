import { LS_JWT_KEY } from "./var.js";

/**
 * Classe qui permet de faire les fetchs CRUD
 * Utile pour les projets avec une API Rest
 */
export class RequestSender {
    /**
     * Fetch en GET
     * @param {String} url url du fetch
     * @returns {JSON} retour du fetch
     */
    static async get(url) {
        try {
            const response = await fetch(url, {
                method: 'GET',
                headers: {
                    "Authorization": 'Bearer ' + localStorage.getItem(LS_JWT_KEY)
                }
            });

            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Erreur lors de la récupération des données :", error.message);
            throw new Error("Erreur lors de la récupération des données");
        }
    }

    /**
     * Fetch en POST
     * @param {String} url url du fetch
     * @returns {JSON} body du fetch (données à envoyer)
     * @returns {JSON} retour du fetch
     */
    static async post(url, jsonbody) {
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    'Authorization': 'Bearer ' + localStorage.getItem(LS_JWT_KEY)
                },
                body: JSON.stringify(jsonbody),
                credentials: "include"
            });
            const data = await response.json();

            if (response.ok) {
                return data;
            } else {
                console.error("Erreur :", data);
                throw new Error(data.error || "Erreur inconnue");
            }
        } catch (error) {
            console.error("Erreur lors de la requête :", error.message);
        }
    }

    /**
     * Fetch en PUT
     * @param {String} url url du fetch
     * @param {JSON} body du fetch (données à envoyer)
     * @returns {JSON} retour du fetch
     */
    static async update(url, jsonbody) {
        try {
            const response = await fetch(url, {
                method: "PUT",
                headers: {
                    "Content-Type": "application/json",
                    'Authorization': 'Bearer ' + localStorage.getItem(LS_JWT_KEY)
                },
                body: JSON.stringify(jsonbody),
            });

            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Erreur lors de la mise à jour des données :", error.message);
            throw new Error("Erreur lors de la mise à jour des données");
        }
    }

    /**
     * Fetch en DELETE
     * @param {String} url url du fetch
     * @returns {JSON} retour du fetch
     */
    static async delete(url) {
        try {
            const response = await fetch(url, {
                method: "DELETE",
                headers: {
                    'Authorization': 'Bearer ' + localStorage.getItem(LS_JWT_KEY)
                }
            });

            if (!response.ok) {
                throw new Error(`Erreur HTTP : ${response.status}`);
            }
            return await response.json();
        } catch (error) {
            console.error("Erreur lors de la suppression des données :", error.message);
            throw new Error("Erreur lors de la suppression des données");
        }
    }
}