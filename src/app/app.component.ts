import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive, RouterOutlet } from '@angular/router';
import { AccueilComponent } from './accueil/accueil.component';
import { ErreurComponent } from './erreur/erreur.component';
import { ClientComponent } from './client/client.component';


@Component({
  selector: 'app-root',
  standalone: true,
  imports: [RouterOutlet, RouterLink, RouterLinkActive, AccueilComponent, ErreurComponent, ClientComponent],
  templateUrl: './app.component.html',
  styleUrl: './app.component.css'
})
export class AppComponent {
  title = 'myapp';
}
