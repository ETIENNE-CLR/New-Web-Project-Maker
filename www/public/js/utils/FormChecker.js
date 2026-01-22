/**
 * FORM CHECKER (classe)
 * @author {Etienne Caulier}
 * Classe JavaScript qui permet de vérifier automatiquement, correctement
 * et simplement les champs d'un formulaire html
 */
export class FormChecker {
    /**
     * Préfixe pour les messages d'erreurs
     */
    PREFIX_ERROR = 'error-FormChecker';

    #relation;
    #form;
    #active;
    #errorColor;
    #submitHandler;

    get Active() { return this.#active }
    get InputIdToVerify() { return Object.keys(this.#relation) }
    get MessageInputError() { return Object.values(this.#relation) }

    /**
     * Constucteur de la classe...
     * @param {json} jsonAssociative Tableau qui définit chaque message pour chaque input à vérifier
     * @param {string|null} idForm id du formulaire
     * @param {string} [errorColor] couleur CSS du texte des erreurs
     */
    constructor(jsonAssociative, idForm, errorColor = '#e91b1b') {
        // Verification
        if (
            typeof jsonAssociative !== 'object' ||
            jsonAssociative === null ||
            Array.isArray(jsonAssociative)
        ) throw new Error('`jsonAssociative` doit être un objet associatif (JSON).');

        let formTemp = document.getElementById(idForm);
        if (!formTemp) throw new Error(`L'id du formulaire passé en paramètre n'est pas valide !`);

        // Setter
        this.#relation = jsonAssociative;
        this.#form = formTemp;
        this.#active = false;
        this.#errorColor = errorColor;
    }

    /**
     * Méthode qui permet d'activer la vérification des champs
     * et permet de définir la fonction à executer
     * après la verification des champs
     * @param {Function} afterCheckingCallback Callback à faire après la vérification des champs (optionnel)
     * @returns {boolean} Si la vérification des champs est activé
     */
    activeCheckField(afterCheckingCallback = undefined) {
        this.#active = true;

        const callback = afterCheckingCallback ?? (() => this.#form.submit());
        this.#submitHandler = (e) => {
            this.#checkField(e, callback);
        };

        if (this.#active) {
            this.#form.addEventListener('submit', this.#submitHandler);
        } else {
            this.#form.removeEventListener('submit', this.#submitHandler);
        }
        return this.Active;
    }

    /**
     * Méthode qui permet de désactiver la vérification des champs
     */
    disabledCheckField() {
        this.#active = false;
    }

    /**
     * Méthode qui empêche l'envoie du formulaire et permet de gérer ce qu'il se passe après la vérification des champs
     * - Autre méthode de vérfication pour le developpeur
     * @param {Event} event Variable d'évenement
     * @param {CallableFunction} afterCheckingCallback Fonction à appeller après la vérification
     */
    #checkField(event, afterCheckingCallback) {
        event.preventDefault();

        // Si tous les champs sont valides
        if (this.#allFieldsValid()) {
            afterCheckingCallback();
        }
    }

    /**
     * Méthode qui permet de cacher tous les messages d'erreurs
     */
    hideAllErrors() {
        document.querySelectorAll(`.${this.PREFIX_ERROR}`).forEach(span => {
            span.remove();
        });
    }

    /**
     * Méthode qui permet de générer un ID unique pour le message d'erreur
     * @param {string} elementId ID de l'element HTML
     * @returns {string} id généré personnalisé de la classe
     */
    getIdFromElementId(elementId) {
        return `${this.PREFIX_ERROR}-${elementId}`;
    }

    /**
     * Fonction qui dit si tous les champs sont rempli ou non
     * @returns {Boolean} dit si tous les champs sont rempli ou non
     */
    #allFieldsValid() {
        // Verifier chaque champs
        let allFieldsValid = true;
        this.InputIdToVerify.forEach(step => {
            // Récupérer le champ
            let inputElement = document.getElementById(step);
            if (!inputElement) throw new Error(`Il n'existe aucun élement #${step} !`);

            // Check
            if (!this.#valueIsSet(inputElement.value)) {
                this.#addErrorMessage(this.#getErrorMessage(step), inputElement);
                allFieldsValid = false;
            } else {
                this.#removeErrorMessage(inputElement);
            }
        });
        return allFieldsValid;
    }

    /**
     * Vérifie si une valeur est définie et non vide
     * @param {String} value Valeur à tester
     * @return {Boolean} True si la valeur est définie, false sinon
     */
    #valueIsSet(value) {
        return (
            value != null &&
            value.toString().trim() !== ''
        ) && (
                // Verification pour les listes déroulantes (select-options)
                !value.toLowerCase().includes('selectionne') &&
                !value.toLowerCase().includes('choisir')
            );
    }

    /**
     * Affiche un message d'erreur sous un élément
     * @param {String} message Message d'erreur
     * @param {HTMLElement} inputElem Élement après lequel insérer le message d'erreur
     */
    #addErrorMessage(message, inputElem) {
        if (!(inputElem instanceof HTMLElement)) throw new Error("Élément HTML invalide");

        const errorId = this.getIdFromElementId(inputElem.id);
        const fieldContainer = inputElem.closest('.mb-3') ?? inputElem.parentElement;

        // Element message d'erreur
        let errorDiv = document.getElementById(errorId);
        if (!errorDiv) {
            errorDiv = document.createElement('div');
            errorDiv.id = errorId;
            errorDiv.classList.add(this.PREFIX_ERROR);
            errorDiv.style.color = this.#errorColor;
            errorDiv.style.display = 'block';
            fieldContainer.appendChild(errorDiv);
        }
        errorDiv.innerText = message;
    }

    /**
     * Supprime le message d'erreur s'il existe
     * @param {HTMLElement} elementBefore Élement avant lequel le message d'erreur est inséré
     */
    #removeErrorMessage(elementBefore) {
        const errorId = this.getIdFromElementId(elementBefore.id);
        let errorMsg = document.getElementById(errorId);
        if (errorMsg) errorMsg.remove();
    }

    /**
     * Envoie le message d'erreur approprié pour chaque champ
     * @param {string} id_input ID du champ
     * @return {string} Message d'erreur
     */
    #getErrorMessage(id_input) {
        return this.#relation[id_input] ?? 'Ce champ est obligatoire !';
    }
}