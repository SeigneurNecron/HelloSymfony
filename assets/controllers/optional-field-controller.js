import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

    static targets = ["checkbox", "row", "field"]

    initialize() {
        this.updateRow();
    }

    submit(event) {
        this.updateField();
    }

    onToggle(event) {
        this.updateRow();
    }

    updateRow() {
        this.rowTarget.hidden = !this.checkboxTarget.checked;
    }

    updateField() {
        if (!this.checkboxTarget.checked) {
            this.fieldTarget.value = "";
        }
    }

}
