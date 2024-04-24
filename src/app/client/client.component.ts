import { Component } from '@angular/core';
import { DashboardComponent } from './dashboard/dashboard.component';
import { GestionComponent } from './gestion/gestion.component';
import { ReservationComponent } from './reservation/reservation.component';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-client',
  standalone: true,
  imports: [DashboardComponent, GestionComponent, ReservationComponent, NgIf],
  templateUrl: './client.component.html',
  styleUrls: ['./client.component.css']
})
export class ClientComponent {
  affDashboard = true;
  affGestion = false;
  affReservation = false;

  afficherDashboard() {
    this.affDashboard = true;
    this.affGestion = false;
    this.affReservation = false;
  }

  afficherGestion() {
    this.affDashboard = false;
    this.affGestion = true;
    this.affReservation = false;
  }

  afficherReservation() {
    this.affDashboard = false;
    this.affGestion = false;
    this.affReservation = true;
  }
}
