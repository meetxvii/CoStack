import {useUser} from '../stores/User';
import axios from 'axios';
export function CheckLogin() {
    const user = useUser();
    axios.get('/api/user').then((response) => {

        if (response.data) {
            user.isLoggedIn = true;
            user.user = response.data;
        }
    }).catch((error) => {
        if(error.response.status===401){
            user.isLoggedIn = false;
            return
        }
        console.log(error.response.data.message);        
    })

    
}