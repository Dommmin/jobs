export interface Offer {
    id: number;
    slug: string;
    title: string;
    company_name: string;
    salary_min: number | null;
    salary_max: number | null;
    location_names: string[];
    work_type_names: string[];
    experience_names: string[];
    contract_names: string[];
    specialization_names: string[];
    created_at: string;
}

export interface OffersResponse {
    data: Offer[];
    links: object;
    total: number;
    from: number;
    to: number;
}
