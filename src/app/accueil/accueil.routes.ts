import { Routes } from '@angular/router';
import { AccueilComponent } from './accueil.component';
import { ErreurComponent } from '../erreur/erreur.component';
import { SignupComponent } from '../signup/signup.component';
import { LoginComponent } from '../login/login.component';


export const routes: Routes = [
    { path: '', redirectTo:'/accueil', pathMatch:'full' },
    { path: 'accueil', component: AccueilComponent },
    { path: 'signup', component: SignupComponent },
    { path: 'login', component: LoginComponent },
    { path: '**', component: ErreurComponent }
];
