import axios from 'axios';

export default class Api
{
	private url:string = 'https://jfc.ddev.site/api/';

    login(data: array) {
		return axios.post(this.url + 'login', data);
	}

	logout() {
		document.cookie = `access_token=''`;
        window.location = '/login';
	}

	checkAuth(page: string = '', loginPage: bool = false) {
		this.get('user')
		.then((response) => {
			if (loginPage) {			
				window.location = page;
			}
		})
	    .catch((error) => {
	        if (!loginPage) {
	        	window.location = '/login';
	        }
	    });
	}

	get(endpoint: string, data: array = {}) {
		return axios({
			method: 'get',
			url: this.url + endpoint,
			data: data,
			headers: {
				Authorization: 'Bearer ' + this.getAccessToken()
			}
		});
	}

	post(endpoint: string, data: array = {}) {
		return axios({
			method: 'post',
			url: this.url + endpoint,
			data: data,
			headers: {
				Authorization: 'Bearer ' + this.getAccessToken()
			}
		});
	}

	put(endpoint: string, data: array = {}) {
		return axios({
			method: 'put',
			url: this.url + endpoint,
			data: data,
			headers: {
				Authorization: 'Bearer ' + this.getAccessToken()
			}
		});
	}

	delete(endpoint: string, data: array = {}) {
		return axios({
			method: 'delete',
			url: this.url + endpoint,
			data: data,
			headers: {
				Authorization: 'Bearer ' + this.getAccessToken()
			}
		});
	}

	getAccessToken() {
        return this.getCookieValue('access_token');
    }

    getCookieValue(key: string) {
    	let name = key + "=";
        let decodedCookie = decodeURIComponent(document.cookie);
        let ca = decodedCookie.split(';');

        for(let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }

            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }

        return "";
    }
}