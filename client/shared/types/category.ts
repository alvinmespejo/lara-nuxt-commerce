type ChildCategory = {
  id: string | number;
  name: string;
  slug: string;
};

export type Category = {
    id: string | number;
    name: string;
    slug: string;
    children?: ChildCategory[]
}