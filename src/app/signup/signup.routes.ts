import { Routes } from '@angular/router';
import { SignupComponent } from './signup.component';
import { AccueilComponent } from '../accueil/accueil.component';
import { LoginComponent } from '../login/login.component';
import { ErreurComponent } from '../erreur/erreur.component';



export const routes: Routes = [
    { path: '', redirectTo:'/accueil', pathMatch:'full' },
    { path: 'accueil', component: AccueilComponent },
    { path: 'signup', component: SignupComponent },
    { path: 'login', component: LoginComponent },
    { path: '**', component: ErreurComponent }
];
