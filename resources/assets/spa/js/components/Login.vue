<template>
    <div class="container">
        <div class="row">
            <div class="card-panel col s8 offset-s2 z-depth-2">
                <h3>Code Financeiro login</h3>
                <form method="POST" @submit.prevent="login()">

                    <div class="row" v-if="error.error">
                        <div class="col s12">
                            <div class="card-panel red">
                                <span class="white-text">{{error.message}}</span>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" name="email" v-model="user.email" required autofocus>
                            <label for="email" class="active">Email</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <input id="password" type="password" class="validate" name="password" v-model="user.password" required>
                            <label for="password" class="active">Senha</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="input-field col s12">
                            <button class="btn">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script type="text/javascript">
    import store from '../store/store';
    export default {
        data(){
            return{
                user: {
                    email: '',
                    password: ''
                },
                error: {
                    error: false,
                    message: ''
                }
            }
        },
        methods: {
            login(){
                store.dispatch('login', this.user)
                    .then(() => this.$router.go({name: 'dashboard'}))
                    .catch((responseError) => {

                        switch(responseError.status){
                            case 401:
                                this.error.message = responseError.data.message;
                            break;
                            default:
                                this.error.message = 'Login failed!';
                            break;
                        }
                        this.error.error = true;
                    })
            }
        }
    }
</script>