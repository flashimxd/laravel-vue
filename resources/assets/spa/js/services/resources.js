export class Jwt{
    static accessToken(email, password){
        return Vue.http.post('access_token', {
            email: email,
            password: password
        })
    }
    static logout(){
        return Vue.http.post('logout');
    }

    static refreshToken(){
        return Vue.http.post('refresh_token');
    }
}

let User = Vue.resource('user');
let BankAccount = Vue.resource('bank_accounts{/id}',{},{
    list: { method: 'GET', url: 'bank_accounts/list'}
});
let Bank = Vue.resource('banks');
//let Category = Vue.resource('categories{/id}');

let CategoryRevenue = Vue.resource('category_revenues{/id}');
let CategoryExpense = Vue.resource('category_expenses{/id}');
let BillPay = Vue.resource('bill_pays{/id}');
let BillReceive = Vue.resource('bill_receives{/id}');

export {User, BankAccount, Bank, CategoryRevenue, CategoryExpense, BillPay, BillReceive};