import {Routes} from '@angular/router';
import { ErreurComponent } from './erreur/erreur.component';
import { AccueilComponent } from './accueil/accueil.component';
import { SignupComponent } from './signup/signup.component';
import { LoginComponent } from './login/login.component';
import { ClientComponent } from './client/client.component';



export const routes: Routes = [
  { path: '', redirectTo:'/accueil', pathMatch:'full' },
  { path: 'accueil', component: AccueilComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'login', component: LoginComponent },
  { path: 'client', component: ClientComponent },
  { path: '**', component: ErreurComponent }
];
