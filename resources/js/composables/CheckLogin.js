import {useUser} from '../stores/User';
import axios from 'axios';
import router from '../router';
export function CheckLogin() {
    const user = useUser();
    axios.get('/api/user').then((response) => {

        if (response.data) {
            user.isLoggedIn = true;
            user.user = response.data;
            if(response.data.is_verified == 0){
                router.push({name:'verification'});
            }
        }
    }).catch((error) => {
        if(error.response.status===401){
            user.isLoggedIn = false;
            return
        }
        console.log(error.response.data.message);        
    })

    
}