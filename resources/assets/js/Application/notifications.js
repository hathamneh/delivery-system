import axios from 'axios';

axios.defaults.headers.common['X-CSRF-TOKEN'] = window.csrf_token;

class NotificationService {
    url = "";

    wrapper = null;
    list = null;
    buttonMarkAllRead = null;

    constructor(props) {
        this.url = props.url;
        this.wrapper = document.querySelector('#notifications-header');
        this.count = this.wrapper.querySelector('.notifications-count');
        this.list = this.wrapper.querySelector('.notifications-list');
        this.buttonMarkAllRead = this.wrapper.querySelector('.read-all');
        this.addEventListeners();
        this.refreshAll()
    }

    addEventListeners = () => {
        this.buttonMarkAllRead.addEventListener('click', this.markAllAsRead);
    }


    renderItem = item => {
        let listItem = document.createElement('div');
        this.list.append(listItem);
        listItem.outerHTML = `
            <div class="list-group-item notification-item list-group-item-action${item.is_read ? "" : " unread"}">
                <a href="${item.url}">
                    <p>${item.message}</p>
                    <small>${item.created_at}</small>
                </a>
            </div>
        `;
    }

    refreshAll = () => {
        axios.get(`${this.url}/refresh`).then(res => {
            this.list.innerHTML = "";
            this.getAll();
        });
    }

    getAll = () => {
        return axios.get(`${this.url}/all`).then(res => {
            if (res.data.unreadCount) {
                this.count.classList.add('d-none');
                this.count.textContent = res.data.unreadCount;
            } else {
                this.count.classList.add('d-none');
            }
            res.data.notifications.forEach(item => {
                this.renderItem({
                    id: item.id,
                    type: item.type,
                    message: item.data.message,
                    url: item.data.link,
                    is_read: item.read_at !== null,
                    created_at: item.created_at,
                });
            });
        }).catch(err => {
            console.log(err);
        })
    }

    markAllAsRead = () => {
        axios.get(`${this.url}/clear`).then(res => {
            this.refreshAll();
        });
    }
}

export default NotificationService;