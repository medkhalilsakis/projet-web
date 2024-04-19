import { Routes } from '@angular/router';
import { ErreurComponent } from '../erreur/erreur.component';
import { AccueilComponent } from '../accueil/accueil.component';


export const routes: Routes = [
    { path: '', redirectTo:'/accueil', pathMatch:'full' },
    { path: 'accueil', component: AccueilComponent },
    { path: '**', component: ErreurComponent }
];
