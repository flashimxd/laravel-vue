<template>
    <div class="container">
        <div class="row">
            <div class="card-panel col s8 offset-s2 z-depth-2">
                <h5>Saindo...</h5>
                <div class="progress">
                    <div class="indeterminate"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from '../store/store';
    export default {
        ready(){
            setTimeout(() => {
                this.logout();
            }, 1000)
        },
        methods: {
            logout(){
                let gotToLogin = this.$router.go({name: 'auth.login'});
                store.dispatch('logout')
                    .then(gotToLogin)
                    .catch(gotToLogin)
            }
        }
    }
</script>