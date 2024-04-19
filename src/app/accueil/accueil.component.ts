import { Component } from '@angular/core';
import { RouterLink, RouterLinkActive } from '@angular/router';

@Component({
  selector: 'app-accueil',
  standalone: true,
  imports: [RouterLink, RouterLinkActive],
  templateUrl: './accueil.component.html',
  styleUrl: './accueil.component.css'
})
export class AccueilComponent {
  cheminImage:any = "/assets/image4.jpg";
}
