import moment from 'moment';

//FILTROS GLOBALES

//Todo Mayúscula
Vue.filter('upText',function(text){
    return text.toUpperCase(); 
});

//Letra tipo Título
Vue.filter('capitalText',function(text){
    return text.charAt(0).toUpperCase()+text.slice(1); 
});

//formato fecha
Vue.filter('miFecha', function(created){
    return moment(created).locale('es').format('D MMMM YYYY, HH:mm:ss ');
});

//formato de subsr
Vue.filter('subStr',function(texto){
    if(texto.length >=40) {
        return texto.substring(0,40)+'...'
    }
    return texto
})