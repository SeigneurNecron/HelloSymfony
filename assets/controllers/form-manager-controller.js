import {Controller} from '@hotwired/stimulus';

export default class extends Controller {

    submit(event) {
        const eventDetail = {preventDefault: false};

        this.dispatch('submit', {
            detail: eventDetail,
            cancelable: false,
        });

        if (eventDetail.preventDefault) {
            event.preventDefault();
        }
    }

}
