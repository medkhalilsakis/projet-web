import { Router, RouterLink, RouterLinkActive } from '@angular/router';
import { NgIf } from '@angular/common';
import { HttpClient, HttpResponse } from '@angular/common/http';
import { Component, OnInit } from '@angular/core';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';

@Component({
  selector: 'app-signup',
  standalone: true,
  imports: [RouterLink, RouterLinkActive, NgIf, FormsModule, HttpClientModule],
  templateUrl: './signup.component.html',
  styleUrl: './signup.component.css'
})
export class SignupComponent implements OnInit{
  ncin?: string;
  nom?: string;
  prenom?: string;
  date_de_naissance?: Date;
  genre?: string;
  adresse?: string;
  gouvernorat?: string;
  code_postal?: string;
  numero_telephone?: string;
  username?: string;
  email?: string;
  password?: string;
  msgerreur: string="";
  msgsuccess: string="";
  

  ngOnInit(){}

  constructor(public http: HttpClient, private router: Router) {}


  inscription(){
    if (
      this.ncin?.trim() == '' ||
      this.nom?.trim() == '' ||
      this.prenom?.trim() == '' ||
      !this.date_de_naissance ||
      this.genre?.trim() == '' ||
      this.adresse?.trim() == '' ||
      this.gouvernorat?.trim() == '' ||
      this.code_postal?.trim() == '' ||
      this.numero_telephone?.trim() == '' ||
      this.username?.trim() == '' ||
      this.email?.trim() == '' ||
      this.password?.trim() == ''
    ) {
      this.msgerreur = "Saisir tous les champs obligatoires";
    }else{
      this.http.post("http://localhost/dashboard/projet/signup.php",{
          "ncin":this.ncin,
          "nom":this.nom,
          "prenom":this.prenom,
          "date_de_naissance":this.date_de_naissance,
          "genre": this.genre,
          "adresse":this.adresse,
          "gouvernorat":this.gouvernorat,
          "code_postal":this.code_postal,
          "numero_telephone":this.numero_telephone,
          "username": this.username,
          "email": this.email,
          "password": this.password
        }, {observe:'response', responseType: 'json'}).subscribe({
          next: (response) => {
            if (response.status == 200) {
              this.msgsuccess = "Ajout client effectué avec succès";
              localStorage.setItem('signupSuccessMessage', "Ajout client effectué avec succès");
              this.router.navigate(['/login']);
            } else {
              const body: any = response.body;
              this.msgerreur = "Echec : " + body['msg'];
            }
          },
              error: (error)=> this.msgerreur = error
            }
        );
      }
    }
  }