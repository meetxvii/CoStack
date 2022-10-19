import {useAdmin} from '../stores/Admin';
import axios from 'axios';
export const CheckAdminLogin = async() => {
    const admin = useAdmin();
    await axios.get('/api/admin/').then((response) => {
        if (response.data) {
            admin.isLoggedIn = true;
            admin.info = response.data;
        }
    }).catch((error) => {
        if(error.response.status===401){
            admin.isLoggedIn = false;
            return
        }
        console.log(error.response.data.message);        
    })
    
}