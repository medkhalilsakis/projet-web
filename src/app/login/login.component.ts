import { Component, Inject, OnInit } from '@angular/core';
import { Router, RouterLink, RouterLinkActive } from '@angular/router';
import { HttpClient, HttpHeaders, HttpResponse } from '@angular/common/http';
import { FormsModule } from '@angular/forms';
import { HttpClientModule } from '@angular/common/http';
import { NgIf } from '@angular/common';

@Component({
  selector: 'app-login',
  standalone: true,
  imports: [RouterLink, RouterLinkActive, FormsModule, HttpClientModule, NgIf],
  templateUrl: './login.component.html',
  styleUrl: './login.component.css'
})
export class LoginComponent implements OnInit{

  username:string|undefined;
  password:string|undefined;
  msgerreur:string="";
  constructor(public http:HttpClient, private router: Router){}

  ngOnInit() {
  }


  connecter(){
    if (
      this.username?.trim() == '' ||
      this.password?.trim() == ''
    ) {
      this.msgerreur = "Saisir tous les champs obligatoires";
    }else{
      this.http.post("http://localhost/dashboard/projet/login.php",{
          "username": this.username,
          "password": this.password
        }, {observe:'response', responseType: 'json'}).subscribe({
          next: (response) => {
            if (response.status == 200) {
              this.msgerreur = "CONNECTE";
              this.router.navigate(['/client']);
            } else {
              const body: any = response.body;
              this.msgerreur = "Echec : " + body['msg'];
            }
          },
          error: (error)=> this.msgerreur = error
          });
     }
  }
}
