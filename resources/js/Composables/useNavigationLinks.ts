export function useNavigationLinks(): { name: string, link: string, type: "cta" | "link" }[] {
    return [
        {name: "Home", type: "link", link: '/v2'},
        {name: "Auftritte", type: "link", link: '/v2/auftritte'},
        {name: "Band", type: "link", link: '/v2/band'},
        {name: "Kontakt", type: "link", link: '/v2/kontakt'},
        {name: "Login", type: "cta", link: '/v2/login'},
    ];
}
