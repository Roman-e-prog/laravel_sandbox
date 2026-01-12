import axios from 'axios';
import Quill from 'quill';
import 'quill/dist/quill.snow.css';

window.Quill = Quill; 
  const toolbarOptions = [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],
  ['link', 'image', 'video', 'formula'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }, { 'list': 'check' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean']                                         // remove formatting button
];
// Only one global listener for all editors
if (!window.__quill_livewire_listener__) {
    window.__quill_livewire_listener__ = true;

    Livewire.on('quill-set-content', (data) => {
        window.dispatchEvent(
            new CustomEvent('quill-set-content-global', { detail: data })
        );
    });
}

window.quillEditor = function ({ field }) {

    // non‑reactive, outside the returned object
    let quillInstance = null;

    return {
        init() {
            const editorEl = this.$refs.editor;

            if (editorEl.__quill_initialized) {
                return;
            }
            editorEl.__quill_initialized = true;

            quillInstance = new Quill(editorEl, {
                theme: 'snow',
                modules: {
                    toolbar: toolbarOptions,
                },
            });


            // Livewire → Quill
            window.addEventListener('quill-set-content-global', (e) => {
                const data = e.detail;
                if (data.field !== field) return;

                applyContent(data.value);
            });

            // Quill → Livewire
            window.addEventListener('request-quill-content', (e) => {
                if (e.detail.field !== field) return;
                if (!quillInstance) return;

                const delta = quillInstance.getContents();

                Livewire.dispatch('quill-content', {
                    field,
                    value: JSON.stringify(delta),
                });
            });
            // Find the closest form and intercept submit
                const form = editorEl.closest('form');
                if (form) {
                    form.addEventListener('submit', () => {
                        if (!quillInstance) return;

                        const delta = quillInstance.getContents();
                        const hidden = document.getElementById(field); 
                        if (!hidden) {
                                console.warn(`Hidden input #${field} not found`);
                            }
                        if (hidden) { 
                            hidden.value = JSON.stringify(delta); 
                        }
                    });
                }

        },
    };

   function applyContent(value) {
    if (!quillInstance) {
        return;
    }

    // CASE 1: Already a Delta object (array with ops)
    if (value && typeof value === 'object' && Array.isArray(value.ops)) {
        quillInstance.setContents(value);
        return;
    }

    // CASE 2: JSON string → decode it
    if (typeof value === 'string' && value.trim() !== '') {
        let parsed;
        try {
            parsed = JSON.parse(value);
        } catch (e) {
            return;
        }

        if (parsed && typeof parsed === 'object' && Array.isArray(parsed.ops)) {
            quillInstance.setContents(parsed);
            return;
        }

        return;
    }

    // CASE 3: Empty or invalid → clear editor
    quillInstance.setContents([]);
}

};












window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
