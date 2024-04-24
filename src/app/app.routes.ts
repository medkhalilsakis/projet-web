import {Routes} from '@angular/router';
import { ErreurComponent } from './erreur/erreur.component';
import { AccueilComponent } from './accueil/accueil.component';
import { SignupComponent } from './signup/signup.component';
import { LoginComponent } from './login/login.component';
import { ClientComponent } from './client/client.component';
import { DashboardComponent } from './client/dashboard/dashboard.component';
import { GestionComponent } from './client/gestion/gestion.component';
import { ReservationComponent } from './client/reservation/reservation.component';



export const routes: Routes = [
  { path: '', redirectTo:'/accueil', pathMatch:'full' },
  { path: 'accueil', component: AccueilComponent },
  { path: 'signup', component: SignupComponent },
  { path: 'login', component: LoginComponent },
  { path: 'client', component: ClientComponent },
  { path: 'dashboard', component: DashboardComponent },
  { path: 'gestion', component: GestionComponent },
  { path: 'reservation', component: ReservationComponent },
  { path: '**', component: ErreurComponent }
];
