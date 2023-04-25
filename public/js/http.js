export default {
    async get(route, data = null) {
        const url = new URL(`http://spa/api${route}`);

        if (data) {
            for (let field in data) {
                url.searchParams.append(field, data[field]);
            }
        }

        const response = await fetch(url, {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
            }
        });
        return await this.handleResponse(response);
    },
    async post(route, data) {
        const response = await fetch(`/api${route}`, {
            method: 'POST',
            body: JSON.stringify(data),
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token'),
            }
        });
        return await this.handleResponse(response);
    },

    async handleResponse(response) {
        const json = await response.json();

        if (response.status >= 200 && response.status < 300) {
            return json?.data || json;
        }

        if (response.status >= 400 && response.status < 500) {
            alert(json.error.message);
            throw new Error(json.error.message);
        }

        if (response.status >= 500 && response.status < 599) {
            alert('Server error');
            throw new Error('Server error');
        }
        return false;
    }
}
