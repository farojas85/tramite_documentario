//IMportando VISTAS VUE
import Home from './views/Home'
import Users from './views/sistema/Users'
import Role from './views/sistema/Role'
import Personal from './views/sistema/Personal'
import Permiso from './views/sistema/Permiso'
import Institucional from './views/configuraciones/Institucional'
import Dessarrollador from './views/sistema/Dessarrollador'

//RUTAS
let routes = [
    { path:'/', name:'home', component: Home},
    { path: '/role', name: 'role',component: Role},
    { path: '/users',name: 'user', component: Users},
    { path: '/desarrollador', name: 'desarrollador', component: Dessarrollador},
    { path: '/personal',name: 'personal', component: Personal},
    { path: '/permiso',name: 'permiso',component: Permiso},
    { path: '/institucional', name:'institucional', component: Institucional}
]

export default  routes