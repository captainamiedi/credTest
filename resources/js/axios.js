import axios from 'axios';
axios.defaults.baseURL = 'http://localhost:8000'
const token = JSON.parse(localStorage.getItem("user-token"));
axios.defaults.headers.common = {'Authorization': `Bearer ${token}`}
export default axios;