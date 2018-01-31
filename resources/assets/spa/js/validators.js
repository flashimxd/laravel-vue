import VeeValidate from 'vee-validate';
import dictPtMessages from './locale/validator/pt_br';
import moment from 'moment';
import 'moment/locale/pt-br';

import numeral from 'numeral';
import 'numeral/locales/pt-br';

moment.locale('pt-br');
numeral.locale('pt-br');

VeeValidate.Validator.extend('date_format_custom', {
    messages: {
        'pt-br': (field, args) => {
            return `O campo ${field} está em um formato inválido`;
        }
    },
    validate: value => {
        return moment(value, 'DD/MM/YYYY').isValid();
    }
});

VeeValidate.Validator.extend('number_format', {
    messages: {
        'pt-br': (field, [min]) => {
            if(typeof min === undefined){
                return `O campo ${field} está em um formato inválido`;
            }else{
                return `O campo ${field} não pode ser menor que ${numeral(parseFloat(min)).format('0,0.00')}`;
            }
        }
    },
    validate: (value, [min]) => {
        let number = numeral(value);
        if(number.value() != null){
            return number.value() >= parseFloat(min);
        }
    }
});

Vue.use(VeeValidate, {
    locale: 'pt-br',
    dictionary: {
        'pt-br': {
            messages: dictPtMessages
        }
    }
});