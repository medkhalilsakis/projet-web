import { RouterLink, RouterLinkActive } from '@angular/router';
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
  ncin:string|undefined;
  nom:string|undefined;
  prenom:string|undefined;
  date_de_naissance:Date|undefined;
  genre:string|undefined;
  adresse:string|undefined;
  gouvernorat:string|undefined;
  code_postal:string|undefined;
  numero_telephone:string|undefined;
  username:string|undefined;
  email:string|undefined;
  password:string|undefined;
  msgerreur:string="";
  msgsuccess:string="";
  

  ngOnInit(){}

  constructor(public http:HttpClient){}

  inscription(){
    if (
      this.ncin?.trim() === '' ||
      this.nom?.trim() === '' ||
      this.prenom?.trim() === '' ||
      !this.date_de_naissance ||
      this.genre?.trim() === '' ||
      this.adresse?.trim() === '' ||
      this.gouvernorat?.trim() === '' ||
      this.code_postal?.trim() === '' ||
      this.numero_telephone?.trim() === '' ||
      this.username?.trim() === '' ||
      this.email?.trim() === '' ||
      this.password?.trim() === ''
    ) {
      this.msgerreur = "Saisir tous les champs obligatoires";
    }else{
    if(this.ncin==undefined || this.nom==undefined || this.prenom ==undefined || this.date_de_naissance==undefined || this.genre==undefined || this.adresse==undefined || this.gouvernorat==undefined || this.code_postal==undefined || this.numero_telephone==undefined || this.email==undefined || this.password ==undefined || this.username == undefined){
        this.msgerreur ="Saisir email and password";
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
              next : (response)=>{
                if(response.status ==201)
                  this.msgsuccess ="Ajout client effectué avec succès";
                else
                  {
                    const body:any= response.body;
                    this.msgerreur="Echec : "+ body['msg'];
                  }
              },
              error: (error)=> this.msgerreur = error
            }
        );
      }
    }
    }
}
