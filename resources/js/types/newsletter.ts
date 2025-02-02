export type NewsletterRequestType = {
    email: string,
    type: 'adding' | 'removing';
    data_privacy_consent: boolean;
    data_privacy_consent_text: string;
};
