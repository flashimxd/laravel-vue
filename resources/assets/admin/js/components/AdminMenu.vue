<template>
    <ul :id="menuItem.id" class="dropdown-content" v-for="menuItem in config.menusDropdown">
        <li v-for="menu in menuItem.items">
            <a :href="menu.url">{{menu.name}}</a>
        </li>
    </ul>

    <ul id="dropdown-logout" class="dropdown-content">
        <li>
            <a :href="config.urlLogout" @click.prevent="logOut()">Sair</a>

            <form id="logout-form" :action="config.urlLogout" method="POST" style="display: none;">
                <input type="hidden" name="_token" :value="config.csrfToken">
            </form>
        </li>
    </ul>

    <div class="navbar-fixed">
        <!-- <nav class="teal"> -->
        <nav>
            <div class="nav-wrapper">

                <div class="col s12">
                    <a href="#" class="left brand-logo">Code Contas - Admin</a>
                    <a href="#" data-activates="nav-mobile" class="button-collapse">
                        <i class="material-icons">menu</i>
                    </a>

                    <ul class="right hide-on-med-and-down">
                        
                        <li v-for="menu in config.menus">
                            <a v-if="menu.dropdownId" class="dropdown-button" href="!#" :data-activates="menu.dropdownId">
                                {{menu.name}} <i class="material-icons right">arrow_drop_down</i>
                            </a>
                            <a v-else :href="menu.url">{{menu.name}}</a>
                        </li>

                        <li>
                            <a class="dropdown-button" href="!#" data-activates="dropdown-logout">
                                {{config.name}} <i class="material-icons right">arrow_drop_down</i>
                            </a>
                        </li>


                    </ul>
                </div>

                <ul id="nav-mobile" class="side-nav">
                    <li v-for="menu in config.menus">
                        <a :href="menu.url">{{menu.name}}</a>
                    </li>
                </ul>

            </div>
        </nav>
    </div>
</template>

<script type="text/javascript">
    export default {
        props: {
            config: {
                type: Object,
                default(){
                    return{
                        name: '',
                        menus: [],
                        menusDropdown: [],
                        urlLogout: 'admin/logout'
                    }
                }
            }
        },
        ready(){
            $('.button-collapse').sideNav();
            $('.dropdown-button').dropdown();
        },
        data() {
            return {
               
            }
        },
        methods: {
            logOut(){
                $('#logout-form').submit();
            }
        }
    };
</script>