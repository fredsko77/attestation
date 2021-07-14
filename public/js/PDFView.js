class PdfView {

    constructor(url, target, options = {}) {
        this.url = url;
        this.target = target;
        this.options = options;
        this.width = window.innerWidth;
    }

    // Affiche la preview du pdf 
    view() {

        let container = document.querySelector(this.target);
        let iframe = container.querySelector('iframe');

        if (iframe !== null) {
            container.innerHTML = '';
        }

        const zoom = this.width > 1500 ? 70 : 60;

        iframe = document.createElement('iframe');
        iframe.setAttribute('allowfullscreen', 'true');
        iframe.setAttribute('type', 'application/pdf');
        iframe.setAttribute('src', `${this.url}#zoom=${zoom}`);
        iframe.setAttribute('frameborder', '0')
        this.setCSS(iframe);

        return container.appendChild(iframe);

    }

    // Définir le CSS de la preview
    setCSS(tag) {
        let style = '';
        for (let option in this.options) {
            style += `${option}: ${this.options[option]};`;
        }
        return tag.setAttribute('style', style);
    }


}