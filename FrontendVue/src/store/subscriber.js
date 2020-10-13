import store from '../store'

export default store.subscribe( (mutation) => {
    console.log(mutation);
});