import { HttpClient } from '@angular/common/http';
import { Injectable } from '@angular/core';

@Injectable({
  providedIn: 'root'
})
export class SignupService {

  url:string = "http://localhost/dashboard/projet/signup.php";

  constructor(public http:HttpClient) { }


 tousProduits()
 {

     return this.http.get(this.url);
 }
 
}
