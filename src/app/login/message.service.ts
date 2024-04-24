export class MessageService {
    private signupSuccessMessage: string = "Ajout avec succes";
  
    setSignupSuccessMessage(message: string) {
      this.signupSuccessMessage = message;
    }
  
    getSignupSuccessMessage(): string | null {
      return this.signupSuccessMessage;
    }
  }
  