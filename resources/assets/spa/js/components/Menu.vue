<template>
    <ul :id="menuItem.id" class="dropdown-content" v-for="menuItem in menusDropdown">
        <li v-for="menu in menuItem.items">
            <a v-link="{name: menu.routeName}">{{menu.name}}</a>
        </li>
    </ul>

    <ul id="dropdown-logout" class="dropdown-content">
        <li>
            <a v-link="{name: 'auth.logout'}">Sair</a>
        </li>
    </ul>

    <div class="navbar-fixed">
        <!-- <nav class="teal"> -->
        <nav>
            <div class="nav-wrapper">

                <div class="col s12">
                    <a href="#" class="left brand-logo">Code Contas - App</a>
                    <a href="#" data-activates="nav-mobile" class="button-collapse">
                        <i class="material-icons">menu</i>
                    </a>

                    <ul class="right hide-on-med-and-down">
                        
                        <li v-for="menu in menus">
                            <a v-if="menu.dropdownId" class="dropdown-button" href="!#" :data-activates="menu.dropdownId">
                                {{menu.name}} <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <a v-else v-link="{name: menu.routeName}">{{menu.name}}</a>
                        </li>

                        <li>
                            <a class="dropdown-button" href="!#" data-activates="dropdown-logout">
                                {{name}} <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>


                    </ul>
                </div>

                <ul id="nav-mobile" class="side-nav">
                    <li v-for="menu in menus">
                        <a :href="menu.url">{{menu.name}}</a>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</template>

<script type="text/javascript">
    import store from '../store/store';
    export default {
        data() {
            return {
                menus: [
                    {name: 'Conta bancária', routeName: 'bank-account.list'},
                    {name: 'Plano de contas',      routeName: 'plans.list'}
                ],
                menusDropdown: []
            }
        },
        computed:{
            name(){
                return store.state.auth.user.name;
            }
        },
        ready(){
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        },
    };
</script>