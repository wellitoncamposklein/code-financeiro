
<template>
    <div class="navbar-fixed">
        <ul :id="o.id" class="dropdown-content" v-for="o in menusDropdown">
            <li v-for="item in o.items">
                <a v-link="{name: item.routeName}">{{item.name}}</a>
            </li>
        </ul>
        <ul id="dropdown-logout" class='dropdown-content'>
            <li>
                <a href="#" @click.prevent="goToMyFinancial()">Meu financeiro</a>
            </li>
            <li>
                <a v-link="{name: 'auth.logout'}">Sair</a>
            </li>
        </ul>
        <nav>
            <div class="nav-wrapper">
                <div class="row">
                    <div class="col s12">
                        <a href="#" class="left brand-logo">Financeiro</a>
                        <a href="#" data-activates="nav-mobile" class="button-collapse right">
                            <i class="material-icons">menu</i>
                        </a>
                        <ul class="right hide-on-med-and-down">
                            <li v-for="o in menus">
                                <a v-if="o.dropdownId" class="dropdown-button" href="!#" :data-activates="o.dropdownId">
                                    {{o.name}} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                                <a v-else v-link="{name: o.routeName}">{{o.name}}</a>
                            </li>
                            <li>
                                <a class="dropdown-button" href="!#" data-activates="dropdown-logout">
                                    {{name}} <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                        </ul>
                        <ul id="nav-mobile" class="side-nav right">
                            <li v-for="o in menus">
                                <a v-link="{name: o.url}">{{o.name}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</template>

<script type="text/javascript">
    import store from '../store/store'
    import appConfig from '../services/appConfig'
    import JwtToken from '../services/jwt-token'

    export default {
        data(){
            return {
                menus: [
                    {name: 'Dashboard', routeName: 'dashboard'},
                    {name: 'Contas', dropdownId: 'bills-dropdown'},
                    {name: 'Conta Bancária', routeName: 'bank-account.list'},
                    {name: 'Plano de contas', routeName: 'plan-account.list'},
                    {name: 'Fluxo de caixa', routeName: 'cash-flow.list'},
                    {name: 'Extrato', routeName: 'statement.list'},
                ],
                menusDropdown: [
                    {
                        id: 'bills-dropdown',
                        items: [
                            {name: "Contas a pagar", routeName: 'bill-pay.list'},
                            {name: "Contas a receber", routeName: 'bill-receive.list'},
                        ]
                    }
                ]
            }
        },
        computed:{
            name(){
                let user = store.state.auth.user
                return user ? user.name : ''
            }
        },
        ready(){
            $('.button-collapse').sideNav()
            $('.dropdown-button').dropdown()
        },
        methods: {
            goToMyFinancial(){
                window.open(
                    `${appConfig.my_financial_path}?token=${JwtToken.token}`,
                    '_blank'
                )
            }
        }
    }
</script>

<style type="text/css" scoped>
    nav ul a{
        font-size: 0.9rem
    }

    .brand-logo{
        font-size: 1.5rem
    }
</style>