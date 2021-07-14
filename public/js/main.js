const getConvention = (el) => {
    const convention = document.getElementById('convention');
    const conventionName = document.getElementById('conventionName');
    const message = document.getElementById('message');

    if (el.value !== "") {
        const url = '/convention/' + el.value;

        // Récupérer la convention de l'étudiant sélectionné
        axios
            .get(url)
            .then(({ data, status }) => {
                if (status === 200) {
                    // Changer la valeur de convention
                    convention.value = data.id;
                    conventionName.value = data.nom;
                    setMessage(data, message);
                }
            })
            .catch(({ response }) => {
                console.log(response);
            })
        return;
    }

    conventionName.value = "";
    return convention.value = "";
}

const setMessage = (data, container) => {
    return container.innerHTML = `
        Bonjour ${data.etudiants[0].nom} ${data.etudiants[0].prenom},\n\r
        Vous avez suivi ${data.nbHeur} heures de formation chez FormationPlus.\n\r
        Pouvez-vous nous retourner ce mail avec la pièce jointe signée.\n\r
        Cordialement,\n\r
        FormationPlus
    `;
}

const handleAttestation = (form, e) => {
    e.preventDefault();

    const data = {
        etudiant: parseInt(document.getElementById('etudiant').value),
        convention: parseInt(document.getElementById('convention').value),
        message: document.getElementById('message').value
    };
    const url = form.action;

    axios
        .post(url, data)
        .then(({ data, status, headers }) => {
            if (status === 201) {
                if (headers.hasOwnProperty('location')) {
                    flash('Attestation créée 🚀');
                    setTimeout(() => {
                        window.location = headers.location;
                    }, 2000)
                }
            }
            if (data) {
                setTexte(data);
            }
        })
        .catch(({ response }) => {
            console.error(response);
        })
}

const setTexte = (attestation = {}) => {
    document.getElementById("attestation-etudiant-nom") = attestation.etudiants[0].nom;
    document.getElementById("attestation-etudiant-prenom") = attestation.etudiants[0].prenom;
    document.getElementById("attestation-etudiant-nbHeur") = attestation.convention.nbHeur;
}